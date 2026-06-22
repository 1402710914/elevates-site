<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors, just log them
ini_set('log_errors', 1);

// Include database connection
include 'db.php';

// Set header for AJAX
header('Content-Type: text/plain');

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'error';
    exit;
}

try {
    // Get and clean data
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $source = trim($_POST['source'] ?? 'unknown');
    
    // Validate required fields
    if (empty($first_name) || empty($email) || empty($subject) || empty($message)) {
        echo 'error';
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'error';
        exit;
    }
    
    // Prepare SQL statement
    $stmt = $mysqli->prepare("
        INSERT INTO enquiries 
        (first_name, last_name, email, phone, company, subject, message, source, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    if (!$stmt) {
        error_log("Prepare failed: " . $mysqli->error);
        echo 'error';
        exit;
    }
    
    // Bind parameters
    $stmt->bind_param(
        'ssssssss',
        $first_name,
        $last_name,
        $email,
        $phone,
        $company,
        $subject,
        $message,
        $source
    );
    
    // Execute statement
    if ($stmt->execute()) {
        echo 'success';
        require_once __DIR__ . '/google_sheet_append.php';
        elevate_after_form_response(function () use ($first_name, $last_name, $email, $phone, $company, $subject, $message, $source) {
            elevate_google_sheet_append_row('Enquiries', [
                date('Y-m-d H:i:s'),
                $source,
                $first_name,
                $last_name,
                $email,
                $phone,
                $company,
                $subject,
                $message,
            ]);
        });
    } else {
        error_log("Execute failed: " . $stmt->error);
        echo 'error';
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    echo 'error';
}

$mysqli->close();
exit;