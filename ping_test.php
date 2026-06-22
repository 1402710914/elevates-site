<?php
require_once 'google_sheet_config.php';

echo "<h1>Google Sheets Ping Test</h1>";

// Test ping
$pingUrl = GOOGLE_SHEET_WEBAPP_URL . '?ping=1&secret=' . urlencode(GOOGLE_SHEET_SECRET);
echo "<p><strong>Ping URL:</strong> $pingUrl</p>";

$ch = curl_init($pingUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
echo "<p><strong>Response Length:</strong> " . strlen($response) . "</p>";

if ($error) {
    echo "<p style='color:red'><strong>cURL Error:</strong> $error</p>";
} elseif ($httpCode === 200) {
    $data = json_decode($response, true);
    if ($data && isset($data['ok']) && $data['ok']) {
        echo "<p style='color:green'><strong>✅ SUCCESS:</strong> Web App is working!</p>";
        echo "<p><strong>Response:</strong> " . json_encode($data) . "</p>";
    } else {
        echo "<p style='color:red'><strong>❌ FAILED:</strong> Invalid response</p>";
        echo "<p><strong>Response:</strong> " . htmlspecialchars(substr($response, 0, 500)) . "</p>";
    }
} else {
    echo "<p style='color:red'><strong>❌ FAILED:</strong> HTTP $httpCode</p>";
    echo "<p><strong>Response:</strong> " . htmlspecialchars(substr($response, 0, 500)) . "</p>";
}
?>