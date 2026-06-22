<?php
/**
 * Append one row to the linked Google Sheet via Apps Script web app.
 * Fails silently to the error log — never breaks form submission.
 */
if (is_file(__DIR__ . '/google_sheet_config.php')) {
    require_once __DIR__ . '/google_sheet_config.php';
}

if (!function_exists('elevate_after_form_response')) {
    /**
     * Run heavy work after the HTTP response is sent (when FastCGI is available).
     */
    function elevate_after_form_response(callable $callback): void
    {
        if (function_exists('fastcgi_finish_request')) {
            if (ob_get_level() > 0) {
                @ob_end_flush();
            }
            @flush();
            fastcgi_finish_request();
        }
        try {
            $callback();
        } catch (Throwable $e) {
            error_log('elevate_after_form_response: ' . $e->getMessage());
        }
    }
}

if (!function_exists('elevate_google_sheet_append_row')) {
    function elevate_google_sheet_append_row(string $sheetName, array $row): void
    {
        $url = defined('GOOGLE_SHEET_WEBAPP_URL') ? GOOGLE_SHEET_WEBAPP_URL : '';
        $secret = defined('GOOGLE_SHEET_SECRET') ? GOOGLE_SHEET_SECRET : '';
        if ($url === '' || $secret === '') {
            return;
        }

        $payload = [
            'secret' => $secret,
            'sheet' => $sheetName,
            'row' => array_map(static function ($v) {
                if ($v === null) {
                    return '';
                }
                if (is_bool($v)) {
                    return $v ? '1' : '0';
                }
                if (is_float($v) || is_int($v)) {
                    return (string) $v;
                }
                return (string) $v;
            }, $row),
        ];

        $body = json_encode($payload, JSON_UNESCAPED_UNICODE);
        if ($body === false) {
            error_log('Google Sheet sync: json_encode failed');
            return;
        }

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            $opts = [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_HTTPHEADER => ['Content-Type: application/json; charset=utf-8'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 25,
                CURLOPT_CONNECTTIMEOUT => 10,
                // Google Web App URL pehle 302/303 deta hai; bina iske POST body kho jati hai
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5,
            ];
            if (defined('CURLOPT_POSTREDIR')) {
                $postRedir = defined('CURL_REDIR_POST_ALL') ? CURL_REDIR_POST_ALL : 7;
                $opts[CURLOPT_POSTREDIR] = $postRedir;
            }
            curl_setopt_array($ch, $opts);
            $resp = curl_exec($ch);
            $err = curl_error($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($err !== '') {
                error_log('Google Sheet sync curl: ' . $err);
                return;
            }
            if ($code < 200 || $code >= 300) {
                error_log('Google Sheet sync HTTP ' . $code . ' body: ' . substr((string) $resp, 0, 500));
                return;
            }
            $decoded = json_decode((string) $resp, true);
            if (!is_array($decoded) || empty($decoded['ok'])) {
                error_log('Google Sheet sync response: ' . substr((string) $resp, 0, 500));
            }
            return;
        }

        $ctx = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/json; charset=utf-8\r\nContent-Length: " . strlen($body) . "\r\n",
                'content' => $body,
                'timeout' => 20,
            ],
        ]);
        $resp = @file_get_contents($url, false, $ctx);
        if ($resp === false) {
            error_log('Google Sheet sync: file_get_contents failed');
        }
    }
}
