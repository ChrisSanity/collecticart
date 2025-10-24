<?php
include("session-config.php");
$conn = new mysqli("localhost", "root", "", "collecticart");

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $page . "?success=1");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

header("Location: wishlist.php");
exit;
