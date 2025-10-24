<?php
require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "LOGIN_REQUIRED"]);
    exit;
}

$current_user = $_SESSION['user_id'];
$partner_id = intval($_GET['partner_id']); 

$sql = "SELECT * FROM messages 
        WHERE (sender_id=? AND receiver_id=?) 
           OR (sender_id=? AND receiver_id=?) 
        ORDER BY created_at ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $current_user, $partner_id, $partner_id, $current_user);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
