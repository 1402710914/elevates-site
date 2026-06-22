<?php
ob_start();

$GLOBALS['elevate_json_api'] = true;

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

try {
    include __DIR__ . '/db.php';
} catch (Throwable $dbError) {
    ob_end_clean();
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    error_log('Landing VSL DB bootstrap error: ' . $dbError->getMessage());
    echo json_encode(['ok' => false, 'message' => 'Database connection failed. Please try again later.']);
    exit;
}

ob_end_clean();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$experience = trim($_POST['experience'] ?? '');
$salary = trim($_POST['salary'] ?? '');
$designation = trim($_POST['designation'] ?? '');
if ($designation === '') {
    $designation = 'Not provided';
}
$looking = trim($_POST['looking'] ?? '');

if ($name === '' || $phone === '' || $email === '' || $experience === '' || $salary === '' || $looking === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

if (!preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter a valid phone number.']);
    exit;
}

function elevate_landing_vsl_ensure_table(mysqli $mysqli): void
{
    $createTableSql = "
        CREATE TABLE IF NOT EXISTS landing_vsl_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(190) NOT NULL,
            experience VARCHAR(80) NOT NULL,
            salary VARCHAR(80) NOT NULL,
            designation TEXT NOT NULL,
            looking_for VARCHAR(190) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ";

    if (!$mysqli->query($createTableSql)) {
        throw new RuntimeException('Failed to ensure landing_vsl_submissions table: ' . $mysqli->error);
    }
}

function elevate_landing_vsl_sync_enquiry(
    mysqli $mysqli,
    string $name,
    string $email,
    string $phone,
    string $experience,
    string $salary,
    string $designation,
    string $looking
): void {
    $message = "New Landing VSL Form Submission\n"
        . "Experience: {$experience}\n"
        . "Current Monthly Salary: {$salary}\n"
        . "Designation: {$designation}\n"
        . "Looking For: {$looking}";

    $lastName = '';
    $company = '';
    $subject = 'New Landing — Free VSL Training';
    $source = 'new_landing';

    $stmtEq = $mysqli->prepare("
        INSERT INTO enquiries
        (first_name, last_name, email, phone, company, subject, message, source, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    if ($stmtEq) {
        $stmtEq->bind_param(
            'ssssssss',
            $name,
            $lastName,
            $email,
            $phone,
            $company,
            $subject,
            $message,
            $source
        );
        $stmtEq->execute();
        $stmtEq->close();
        return;
    }

    // Fallback for older live DB schemas without `source` column.
    $stmtLegacy = $mysqli->prepare("
        INSERT INTO enquiries
        (first_name, last_name, email, phone, company, subject, message, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtLegacy) {
        throw new RuntimeException('Failed to prepare enquiries insert: ' . $mysqli->error);
    }

    $stmtLegacy->bind_param(
        'sssssss',
        $name,
        $lastName,
        $email,
        $phone,
        $company,
        $subject,
        $message
    );
    $stmtLegacy->execute();
    $stmtLegacy->close();
}

$inTransaction = false;

try {
    elevate_landing_vsl_ensure_table($mysqli);

    $mysqli->begin_transaction();
    $inTransaction = true;

    $stmtLanding = $mysqli->prepare("
        INSERT INTO landing_vsl_submissions
        (name, phone, email, experience, salary, designation, looking_for, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtLanding) {
        throw new RuntimeException('Failed to prepare landing submission insert: ' . $mysqli->error);
    }

    $stmtLanding->bind_param(
        'sssssss',
        $name,
        $phone,
        $email,
        $experience,
        $salary,
        $designation,
        $looking
    );

    if (!$stmtLanding->execute()) {
        throw new RuntimeException('Failed to save landing submission: ' . $stmtLanding->error);
    }
    $stmtLanding->close();

    $mysqli->commit();
    $inTransaction = false;

    try {
        elevate_landing_vsl_sync_enquiry(
            $mysqli,
            $name,
            $email,
            $phone,
            $experience,
            $salary,
            $designation,
            $looking
        );
    } catch (Throwable $enquiryError) {
        error_log('Landing VSL enquiries sync error: ' . $enquiryError->getMessage());
    }

    echo json_encode([
        'ok' => true,
        'message' => 'Thank you! Your details have been submitted successfully. Enjoy your free training.',
    ]);
} catch (Throwable $e) {
    if (!empty($inTransaction)) {
        $mysqli->rollback();
    }
    error_log('Landing VSL save error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to submit right now. Please try again.']);
}

$mysqli->close();
