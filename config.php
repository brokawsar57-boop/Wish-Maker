<?php
// 1) Replace these database values with the ones shown in your InfinityFree Control Panel.
// 2) Change ADMIN_PASSWORD before publishing. Use a long, unique password.
define('DB_HOST', 'sqlXXX.infinityfree.com');
define('DB_NAME', 'if0_XXXXXXXX_wishes');
define('DB_USER', 'if0_XXXXXXXX');
define('DB_PASS', 'CHANGE_DATABASE_PASSWORD');
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'CHANGE_THIS_TO_A_LONG_UNIQUE_PASSWORD');
define('SITE_NAME', 'WishMaker');
define('BASE_URL', ''); // Optional, e.g. https://your-subdomain.infinityfreeapp.com. Leave blank to auto-detect.
function db() {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
    return $pdo;
}
function site_url($path='') {
    if (BASE_URL !== '') return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
    $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $scheme = $https ? 'https' : 'http';
    return $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/' . ltrim($path, '/');
}
function esc($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
