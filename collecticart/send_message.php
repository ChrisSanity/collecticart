<?php include("session-config.php"); 
$conn = new mysqli("localhost", "root", "", "collecticart");

// Require login
if (!isset($_SESSION['user_id'])) {
    echo "LOGIN_REQUIRED"; // JS will handle this
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = intval($_POST['receiver_id']);
    $message = trim($_POST['message']);

    if ($message !== "") {
        $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
        $stmt->execute();
        echo "OK";
    }
}
