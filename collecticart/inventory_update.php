<?php
require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $stocks = intval($_POST['stocks']);
    $availability = $_POST['availability'];

    $sql = "UPDATE products SET stocks = ?, availability = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $stocks, $availability, $id);

    if ($stmt->execute()) {
        echo "✅ Updated successfully!";
    } else {
        echo "❌ Error updating product.";
    }
}
