<?php
// Always start session
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', 3600); // 1 hour
    session_set_cookie_params([
        'lifetime' => 3600,        // cookie lasts 1 hour
        'path' => '/',
        'httponly' => true,        // prevent JS access
        'secure' => isset($_SERVER['HTTPS']), // use HTTPS if available
        'samesite' => 'Lax'        // helps prevent CSRF
    ]);
    session_start();
}

// Sliding expiration logic
if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > 3600) {
        // Inactive for more than 1 hour → destroy session
        session_unset();
        session_destroy();
    } else {
        // Reset timer if user is still active
        $_SESSION['LAST_ACTIVITY'] = time();
    }
} else {
    // First activity
    $_SESSION['LAST_ACTIVITY'] = time();
}

// Track navigation history
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

// Avoid pushing the same page twice in a row
$current = $_SERVER['REQUEST_URI'];
if (empty($_SESSION['history']) || end($_SESSION['history']) !== $current) {
    $_SESSION['history'][] = $current;
}

// Keep only the last 5 pages to avoid long session arrays
if (count($_SESSION['history']) > 5) {
    array_shift($_SESSION['history']);
}

?>
