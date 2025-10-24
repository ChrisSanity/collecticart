<?php
header('Content-Type: application/json; charset=utf-8');

$conn = new mysqli("localhost", "root", "", "collecticart");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed.'
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method not allowed.'
    ]);
    exit;
}

$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$passwordRaw = isset($_POST['password']) ? $_POST['password'] : '';

if ($fullname === '' || $username === '' || $passwordRaw === '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'All fields are required.'
    ]);
    exit;
}

$password = password_hash($passwordRaw, PASSWORD_BCRYPT);

$sql = "INSERT INTO users (fullname, username, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to prepare statement.'
    ]);
    exit;
}

$stmt->bind_param("sss", $fullname, $username, $password);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Account created successfully. You can now log in.'
    ]);
} else {
    // Duplicate username handling if a UNIQUE index exists on username
    if ($stmt->errno === 1062) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'Username is already taken.'
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Error creating account. Please try again.'
        ]);
    }
}

$stmt->close();
$conn->close();
