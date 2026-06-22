<?php
/**
 * Sheet sync test — browser se kholo, "Test bhejo" dabao.
 * Kaam ho jaye to is file ko delete kar dena ya rename (security).
 */
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/google_sheet_config.php';

$url = defined('GOOGLE_SHEET_WEBAPP_URL') ? GOOGLE_SHEET_WEBAPP_URL : '';
$secret = defined('GOOGLE_SHEET_SECRET') ? GOOGLE_SHEET_SECRET : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['run_test'])) {
    if ($url === '' || $secret === '') {
        echo '<p style="color:red">Pehle <code>google_sheet_config.php</code> me URL aur SECRET bharo.</p>';
        exit;
    }
    if (!function_exists('curl_init')) {
        echo '<p style="color:red">PHP me cURL enable nahi hai — XAMPP me php.ini me <code>extension=curl</code> on karo.</p>';
        exit;
    }

    require_once __DIR__ . '/google_sheet_append.php';

    $payload = [
        'secret' => $secret,
        'sheet' => 'Enquiries',
        'row' => [
            date('Y-m-d H:i:s'),
            'test_google_sheet_php',
            'Test',
            'User',
            'test-sheet@example.com',
            '',
            '',
            'Sheet ping',
            'Agar ye row dikhe to sync theek hai.',
        ],
    ];
    $body = json_encode($payload, JSON_UNESCAPED_UNICODE);

    $ch = curl_init($url);
    $opts = [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf-8'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 25,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
    ];
    if (defined('CURLOPT_POSTREDIR')) {
        $opts[CURLOPT_POSTREDIR] = defined('CURL_REDIR_POST_ALL') ? CURL_REDIR_POST_ALL : 7;
    }
    curl_setopt_array($ch, $opts);
    $resp = curl_exec($ch);
    $err = curl_error($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo '<h2>Server response</h2>';
    echo '<p>HTTP code: <strong>' . htmlspecialchars((string) $code) . '</strong></p>';
    if ($err !== '') {
        echo '<p style="color:red">cURL error: ' . htmlspecialchars($err) . '</p>';
    }
    echo '<pre style="background:#f5f5f5;padding:12px;overflow:auto">' . htmlspecialchars((string) $resp) . '</pre>';
    $j = json_decode((string) $resp, true);
    if (is_array($j) && !empty($j['ok'])) {
        echo '<p style="color:green;font-size:120%"><strong>OK.</strong> Google Sheet → tab <code>Enquiries</code> me last row dekho.</p>';
    } elseif (is_array($j) && isset($j['error'])) {
        echo '<p style="color:#b00">Google ne error bheja: <code>' . htmlspecialchars((string) $j['error']) . '</code></p>';
        if (($j['error'] ?? '') === 'unauthorized') {
            echo '<p>Script ke <code>WEBAPP_SECRET</code> aur PHP ke <code>GOOGLE_SHEET_SECRET</code> <strong>exact same</strong> hone chahiye (copy-paste).</p>';
        }
    }
    echo '<p><a href="test_google_sheet.php">Wapas</a></p>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Sheet test</title>
</head>
<body style="font-family:system-ui,sans-serif;max-width:42rem;margin:2rem auto;padding:0 1rem">
    <h1>Google Sheet sync — test</h1>
    <p>URL set: <strong><?= $url !== '' ? 'Haan' : 'Nahi' ?></strong> &nbsp;|&nbsp; Secret set: <strong><?= $secret !== '' ? 'Haan' : 'Nahi' ?></strong></p>
    <?php if ($url === '' || $secret === ''): ?>
        <ol>
            <li><code>one/google_sheet_config.php</code> kholo.</li>
            <li><code>GOOGLE_SHEET_WEBAPP_URL</code> = Deploy se mila <em>Web app</em> URL (ends with <code>/exec</code>).</li>
            <li><code>GOOGLE_SHEET_SECRET</code> = Apps Script file me jo <code>WEBAPP_SECRET</code> likha hai, wahi exact string.</li>
        </ol>
    <?php else: ?>
        <form method="post">
            <button type="submit" name="run_test" value="1" style="padding:10px 18px;font-size:1rem">Test row bhejo (Enquiries tab)</button>
        </form>
        <p style="margin-top:1.5rem;font-size:0.9rem;color:#444">Optional: Web app URL ke end par <code>?ping=1&amp;secret=...</code> lagakar kholo — response me <code>"ok":true</code> ho to deploy sahi hai. (Ye URL kisi ko mat bhejo — usme secret hota hai.)</p>
    <?php endif; ?>
    <p style="margin-top:2rem"><a href="google-apps-script/SETUP-STEPS.txt">Setup steps (Roman Hindi + English)</a></p>
</body>
</html>
