<?php
$conn = new mysqli("localhost", "root", "", "collecticart");

include("session-config.php");

// Redirect back safely if not logged in
if (!isset($_SESSION['user_id'])) {
    $ref = $_SERVER['HTTP_REFERER'] ?? 'all-products.php';
    $sep = parse_url($ref, PHP_URL_QUERY) ? '&' : '?';
    header("Location: {$ref}{$sep}success=1");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

// Check if product already in wishlist
$sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Remove if exists
    $sql = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
} else {
    // Add if not exists
    $sql = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

$ref = $_SERVER['HTTP_REFERER'] ?? 'all-products.php';
$sep = parse_url($ref, PHP_URL_QUERY) ? '&' : '?';
header("Location: {$ref}{$sep}success=1");
exit;
