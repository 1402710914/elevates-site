<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include __DIR__ . '/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');
$organization_name = trim($_POST['organization_name'] ?? '');
$resources_salary = trim($_POST['resources_salary'] ?? '');
$consent = $_POST['consent_hiring_assistance'] ?? '';

if ($consent !== '1') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please accept the disclaimer to continue.']);
    exit;
}

if ($name === '' || $phone === '' || $email === '' || $organization_name === '' || $resources_salary === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

$rsLen = function_exists('mb_strlen') ? mb_strlen($resources_salary) : strlen($resources_salary);
if ($rsLen < 15) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please describe the roles or resources you need and the salary range in a bit more detail.']);
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

try {
    $createTableSql = "
        CREATE TABLE IF NOT EXISTS hiring_assistance_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(190) NOT NULL,
            organization_name VARCHAR(190) NOT NULL,
            resources_salary TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $mysqli->query($createTableSql);

    $mysqli->begin_transaction();

    $stmtH = $mysqli->prepare("
        INSERT INTO hiring_assistance_submissions
        (name, phone, email, organization_name, resources_salary, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtH) {
        throw new Exception('Failed to prepare hiring assistance insert.');
    }
    $stmtH->bind_param('sssss', $name, $phone, $email, $organization_name, $resources_salary);
    $stmtH->execute();
    $stmtH->close();

    $message = "Hiring Assistance Request\n"
        . "Organization: {$organization_name}\n"
        . "Resources needed & salary package:\n{$resources_salary}\n\n"
        . "Consent: Submitter agreed to ELEVATES using submitted information for job assistance and recruitment-related purposes, including sharing profile with potential employers or hiring partners for relevant job opportunities.";

    $stmtEq = $mysqli->prepare("
        INSERT INTO enquiries
        (first_name, last_name, email, phone, company, subject, message, source, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtEq) {
        throw new Exception('Failed to prepare enquiries insert.');
    }
    $lastName = '';
    $subject = 'Hiring Assistance';
    $source = 'hiring_assistance';
    $stmtEq->bind_param(
        'ssssssss',
        $name,
        $lastName,
        $email,
        $phone,
        $organization_name,
        $subject,
        $message,
        $source
    );
    $stmtEq->execute();
    $stmtEq->close();

    $mysqli->commit();

    echo json_encode(['ok' => true, 'message' => 'Thank you! We have received your hiring request and will get back to you shortly.']);
    require_once __DIR__ . '/google_sheet_append.php';
    elevate_after_form_response(function () use ($name, $phone, $email, $organization_name, $resources_salary) {
        elevate_google_sheet_append_row('Hiring_Assistance', [
            date('Y-m-d H:i:s'),
            $name,
            $phone,
            $email,
            $organization_name,
            $resources_salary,
        ]);
    });
} catch (Throwable $e) {
    if ($mysqli->errno) {
        $mysqli->rollback();
    }
    error_log('Hiring assistance save error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to submit right now. Please try again.']);
}

$mysqli->close();
