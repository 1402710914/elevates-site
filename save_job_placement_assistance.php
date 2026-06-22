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
$total_experience_years = trim($_POST['total_experience_years'] ?? '');
$qualification = trim($_POST['qualification'] ?? '');
$current_organization = trim($_POST['current_organization'] ?? '');
$designation_expertise = trim($_POST['designation_expertise'] ?? '');
$current_ctc = trim($_POST['current_ctc'] ?? '');
$expected_ctc = trim($_POST['expected_ctc'] ?? '');
$consent = $_POST['consent_job_placement'] ?? '';

if ($consent !== '1') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please accept the disclaimer to continue.']);
    exit;
}

if (
    $name === '' || $phone === '' || $email === '' || $total_experience_years === '' ||
    $qualification === '' || $current_organization === '' || $designation_expertise === '' ||
    $current_ctc === '' || $expected_ctc === ''
) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

$expertiseLen = function_exists('mb_strlen') ? mb_strlen($designation_expertise) : strlen($designation_expertise);
if ($expertiseLen < 20) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please describe your designation and area of expertise in more detail (at least a few sentences).']);
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

$experience_value = is_numeric($total_experience_years) ? (float)$total_experience_years : null;
if ($experience_value === null || $experience_value < 0 || $experience_value > 50) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'message' => 'Please enter valid total years of experience (0 if you are a fresher).']);
    exit;
}

try {
    $createTableSql = "
        CREATE TABLE IF NOT EXISTS job_placement_assistance_submissions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(190) NOT NULL,
            total_experience_years DECIMAL(4,1) NOT NULL,
            qualification VARCHAR(190) NOT NULL,
            current_organization VARCHAR(190) NOT NULL,
            designation_expertise TEXT NOT NULL,
            current_ctc VARCHAR(80) NOT NULL,
            expected_ctc VARCHAR(80) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $mysqli->query($createTableSql);

    $mysqli->begin_transaction();

    $stmtJp = $mysqli->prepare("
        INSERT INTO job_placement_assistance_submissions
        (name, phone, email, total_experience_years, qualification, current_organization, designation_expertise, current_ctc, expected_ctc, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtJp) {
        throw new Exception('Failed to prepare job placement insert.');
    }
    $stmtJp->bind_param(
        'sssdsssss',
        $name,
        $phone,
        $email,
        $experience_value,
        $qualification,
        $current_organization,
        $designation_expertise,
        $current_ctc,
        $expected_ctc
    );
    $stmtJp->execute();
    $stmtJp->close();

    $message = "Job & Placement Assistance — Profile\n"
        . "Total Years of Experience: {$total_experience_years}\n"
        . "Qualification: {$qualification}\n"
        . "Current Organization: {$current_organization}\n"
        . "Designation & Expertise:\n{$designation_expertise}\n"
        . "Current CTC: {$current_ctc}\n"
        . "Expected CTC: {$expected_ctc}\n\n"
        . "Consent: Applicant agreed to ELEVATES using submitted information for job assistance and recruitment-related purposes, including sharing profile with potential employers or hiring partners.";

    $stmtEq = $mysqli->prepare("
        INSERT INTO enquiries
        (first_name, last_name, email, phone, company, subject, message, source, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmtEq) {
        throw new Exception('Failed to prepare enquiries insert.');
    }
    $lastName = '';
    $subject = 'Job & Placement Assistance';
    $source = 'job_placement_assistance';
    $stmtEq->bind_param(
        'ssssssss',
        $name,
        $lastName,
        $email,
        $phone,
        $current_organization,
        $subject,
        $message,
        $source
    );
    $stmtEq->execute();
    $stmtEq->close();

    $mysqli->commit();

    echo json_encode(['ok' => true, 'message' => 'Thank you! Your request has been submitted. Our team will contact you soon.']);
    require_once __DIR__ . '/google_sheet_append.php';
    elevate_after_form_response(function () use (
        $name,
        $phone,
        $email,
        $total_experience_years,
        $qualification,
        $current_organization,
        $designation_expertise,
        $current_ctc,
        $expected_ctc
    ) {
        elevate_google_sheet_append_row('Job_Placement', [
            date('Y-m-d H:i:s'),
            $name,
            $phone,
            $email,
            $total_experience_years,
            $qualification,
            $current_organization,
            $designation_expertise,
            $current_ctc,
            $expected_ctc,
        ]);
    });
} catch (Throwable $e) {
    if ($mysqli->errno) {
        $mysqli->rollback();
    }
    error_log('Job placement assistance save error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Unable to submit right now. Please try again.']);
}

$mysqli->close();
