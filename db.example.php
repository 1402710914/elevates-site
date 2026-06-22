<?php
// Copy this file to db.php and set your database credentials.
// db.php is not tracked in Git.

$host = 'localhost';
$username = 'your_db_user';
$password = 'your_db_password';
$database = 'your_db_name';

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    error_log("Database connection failed: " . $mysqli->connect_error);
    if (!empty($GLOBALS['elevate_json_api'])) {
        if (!headers_sent()) {
            header('Content-Type: application/json');
            http_response_code(500);
        }
        echo json_encode(['ok' => false, 'message' => 'Database connection failed. Please try again later.']);
        exit;
    }
    die("Connection failed. Please try again later.");
}

$mysqli->set_charset("utf8mb4");
