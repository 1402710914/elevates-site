<?php
/**
 * Copy to google_sheet_config.php and fill in your values.
 * google_sheet_config.php is not tracked in Git.
 */

if (!defined('GOOGLE_SHEET_WEBAPP_URL')) {
    define('GOOGLE_SHEET_WEBAPP_URL', 'https://script.google.com/macros/s/YOUR_SCRIPT_ID/exec');
}

if (!defined('GOOGLE_SHEET_SECRET')) {
    define('GOOGLE_SHEET_SECRET', 'your_secret_here');
}
