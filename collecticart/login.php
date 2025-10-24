<?php
/* include("session-config.php"); 
header('Content-Type: application/json; charset=utf-8');

$response = ["success" => false, "message" => ""];

$conn = new mysqli("localhost", "root", "", "collecticart");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: database connection failed.'
    ]);
    exit;
}
$conn->set_charset('utf8mb4');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    $conn->close();
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Username and password are required.'
    ]);
    $conn->close();
    exit;
}

// Detect if the users table has a `role` column
$hasRole = false;
$colCheck = $conn->query("SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME='users' AND COLUMN_NAME='role'");
if ($colCheck && $colCheck->num_rows > 0) {
    $hasRole = true;
}
if ($colCheck) { $colCheck->free(); }

$sql = $hasRole
    ? "SELECT id, username, password, role FROM users WHERE username = ?"
    : "SELECT id, username, password FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: failed to prepare statement.'
    ]);
    $conn->close();
    exit;
}

$stmt->bind_param("s", $username);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: failed to execute query.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$result = $stmt->get_result();
if (!$result || $result->num_rows !== 1) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => '⚠️ No account found with that username.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => '⚠️ Invalid password.'
    ]);
    $conn->close();
    exit;
}

// Determine role (fallback to username-based admin if schema lacks `role`)
$role = 'user';
if ($hasRole) {
    $role = !empty($user['role']) ? $user['role'] : 'user';
} else {
    // If your DB doesn't have a `role` column yet, treat username 'admin' as admin
    if (strcasecmp($user['username'], 'admin') === 0) {
        $role = 'admin';
    }
}

// Set session
$_SESSION['user_id']   = (int)$user['id'];
$_SESSION['username']  = (string)$user['username'];
$_SESSION['role']      = $role;
$_SESSION['LAST_ACTIVITY'] = time();

// Redirect preference: explicit intent -> history -> role -> home
if (!empty($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);
} elseif (isset($_SESSION['history']) && count($_SESSION['history']) >= 2) {
    $redirect = $_SESSION['history'][count($_SESSION['history']) - 2];
} elseif ($role === 'admin') {
    $redirect = 'admin-dashboard.php';
} else {
    $redirect = 'home.php';
}

echo json_encode([
    'success' => true,
    'redirect' => $redirect
]);

$conn->close();
exit; */

/* include("session-config.php"); 
header('Content-Type: application/json; charset=utf-8');

$response = ["success" => false, "message" => ""];

$conn = new mysqli("localhost", "root", "", "collecticart");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: database connection failed.'
    ]);
    exit;
}
$conn->set_charset('utf8mb4');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    $conn->close();
    exit;
}

// Get and sanitize input - DO NOT trim the password!
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Username and password are required.'
    ]);
    $conn->close();
    exit;
}

// Detect if the users table has a `role` column
$hasRole = false;
$colCheck = $conn->query("SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME='users' AND COLUMN_NAME='role'");
if ($colCheck && $colCheck->num_rows > 0) {
    $hasRole = true;
}
if ($colCheck) { $colCheck->free(); }

$sql = $hasRole
    ? "SELECT id, username, password, role FROM users WHERE username = ?"
    : "SELECT id, username, password FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: failed to prepare statement.'
    ]);
    $conn->close();
    exit;
}

$stmt->bind_param("s", $username);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: failed to execute query.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$result = $stmt->get_result();
if (!$result || $result->num_rows !== 1) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => '⚠️ No account found with that username.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Verify password
if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => '⚠️ Invalid password.'
    ]);
    $conn->close();
    exit;
}

// Determine role (fallback to username-based admin if schema lacks `role`)
$role = 'user';
if ($hasRole) {
    $role = !empty($user['role']) ? $user['role'] : 'user';
} else {
    // If your DB doesn't have a `role` column yet, treat username 'admin' as admin
    if (strcasecmp($user['username'], 'admin') === 0) {
        $role = 'admin';
    }
}

// Set session
$_SESSION['user_id']   = (int)$user['id'];
$_SESSION['username']  = (string)$user['username'];
$_SESSION['role']      = $role;
$_SESSION['LAST_ACTIVITY'] = time();

// Redirect preference: explicit intent -> history -> role -> home
if (!empty($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);
} elseif (isset($_SESSION['history']) && count($_SESSION['history']) >= 2) {
    $redirect = $_SESSION['history'][count($_SESSION['history']) - 2];
} elseif ($role === 'admin') {
    $redirect = 'admin-dashboard.php';
} else {
    $redirect = 'home.php';
}

echo json_encode([
    'success' => true,
    'redirect' => $redirect
]);

$conn->close();
exit;
 */


include("session-config.php"); 
header('Content-Type: application/json; charset=utf-8');

$response = ["success" => false, "message" => ""];

$conn = new mysqli("localhost", "root", "", "collecticart");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: database connection failed.'
    ]);
    exit;
}
$conn->set_charset('utf8mb4');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    $conn->close();
    exit;
}

// Get and sanitize input - DO NOT trim the password!
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Username and password are required.'
    ]);
    $conn->close();
    exit;
}

// Detect if the users table has a `role` column
$hasRole = false;
$colCheck = $conn->query("SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME='users' AND COLUMN_NAME='role'");
if ($colCheck && $colCheck->num_rows > 0) {
    $hasRole = true;
}
if ($colCheck) { $colCheck->free(); }

$sql = $hasRole
    ? "SELECT id, username, password, role FROM users WHERE username = ?"
    : "SELECT id, username, password FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: failed to prepare statement.'
    ]);
    $conn->close();
    exit;
}

$stmt->bind_param("s", $username);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: failed to execute query.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$result = $stmt->get_result();
if (!$result || $result->num_rows !== 1) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => '⚠️ No account found with that username.'
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

// Verify password
if (!password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => '⚠️ Invalid password.'
    ]);
    $conn->close();
    exit;
}

// Determine role (fallback to username-based admin if schema lacks `role`)
$role = 'user';
if ($hasRole) {
    $role = !empty($user['role']) ? $user['role'] : 'user';
} else {
    // If your DB doesn't have a `role` column yet, treat username 'admin' as admin
    if (strcasecmp($user['username'], 'admin') === 0) {
        $role = 'admin';
    }
}

// Set session
$_SESSION['user_id']   = (int)$user['id'];
$_SESSION['username']  = (string)$user['username'];
$_SESSION['role']      = $role;
$_SESSION['LAST_ACTIVITY'] = time();

// Redirect preference: explicit intent -> role for admin -> history -> home
if (!empty($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);
} elseif ($role === 'admin') {
    // Always redirect admin to dashboard, ignore history
    $redirect = 'admin-dashboard.php';
} elseif (isset($_SESSION['history']) && count($_SESSION['history']) >= 2) {
    $redirect = $_SESSION['history'][count($_SESSION['history']) - 2];
} else {
    $redirect = 'home.php';
}

echo json_encode([
    'success' => true,
    'redirect' => $redirect
]);

$conn->close();
exit;