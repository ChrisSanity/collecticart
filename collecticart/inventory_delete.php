<?php
require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Product deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
