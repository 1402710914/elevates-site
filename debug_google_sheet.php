<?php
/**
 * Google Sheets Debug Test
 * Run this to check your setup step by step
 */
header('Content-Type: text/html; charset=utf-8');
echo "<h1>Google Sheets Debug Test</h1>";

// Check config
require_once __DIR__ . '/google_sheet_config.php';

$url = defined('GOOGLE_SHEET_WEBAPP_URL') ? GOOGLE_SHEET_WEBAPP_URL : '';
$secret = defined('GOOGLE_SHEET_SECRET') ? GOOGLE_SHEET_SECRET : '';

echo "<h2>1. Configuration Check</h2>";
echo "<strong>Web App URL:</strong> " . ($url ? "<span style='color:green'>Set</span>" : "<span style='color:red'>NOT SET</span>") . "<br>";
echo "<strong>Secret:</strong> " . ($secret ? "<span style='color:green'>Set</span>" : "<span style='color:red'>NOT SET</span>") . "<br>";

if ($url === 'YOUR_ACTUAL_WEB_APP_URL_HERE' || $secret === 'YOUR_SECRET_HERE') {
    echo "<span style='color:red'><strong>ERROR:</strong> You haven't updated the config with real values!</span><br>";
    echo "Please update google_sheet_config.php with your actual web app URL and secret.<br>";
    exit;
}

echo "<h2>2. cURL Check</h2>";
if (!function_exists('curl_init')) {
    echo "<span style='color:red'>cURL is not enabled in PHP</span><br>";
    echo "Enable it in php.ini: extension=curl<br>";
    exit;
} else {
    echo "<span style='color:green'>cURL is available</span><br>";
}

echo "<h2>3. Web App Ping Test</h2>";
$pingUrl = $url . '?ping=1&secret=' . urlencode($secret);

$ch = curl_init($pingUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<strong>Ping URL:</strong> $pingUrl<br>";
echo "<strong>HTTP Code:</strong> $httpCode<br>";

if ($error) {
    echo "<strong>cURL Error:</strong> <span style='color:red'>$error</span><br>";
} else {
    echo "<strong>Response:</strong> $response<br>";
}

if ($httpCode === 200) {
    $data = json_decode($response, true);
    if ($data && isset($data['ok']) && $data['ok']) {
        echo "<span style='color:green'><strong>✅ Web App is working!</strong></span><br>";
    } else {
        echo "<span style='color:red'>❌ Web App responded but with error</span><br>";
    }
} else {
    echo "<span style='color:red'>❌ Web App not accessible (HTTP $httpCode)</span><br>";
}

echo "<h2>4. Manual Test Form</h2>";
if ($url && $secret && $httpCode === 200) {
    echo "<form method='POST'>
        <button type='submit' name='test_sheet' style='padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;'>Test Google Sheet Row</button>
    </form>";
}

if (isset($_POST['test_sheet'])) {
    echo "<h3>Test Result:</h3>";

    require_once __DIR__ . '/google_sheet_append.php';

    $testData = [
        date('Y-m-d H:i:s'),
        'debug_test',
        'Test',
        'User',
        'test@example.com',
        '1234567890',
        'Test Company',
        'Debug Test',
        'This is a test message from debug script'
    ];

    try {
        elevate_after_form_response(function () use ($testData) {
            elevate_google_sheet_append_row('Enquiries', $testData);
        });

        echo "<span style='color:green'>✅ Test data sent to Google Sheets!</span><br>";
        echo "<strong>Check your Google Sheet 'Enquiries' tab for a new row.</strong><br>";
    } catch (Exception $e) {
        echo "<span style='color:red'>❌ Error: " . $e->getMessage() . "</span><br>";
    }
}
?>