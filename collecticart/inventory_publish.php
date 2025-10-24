<?php
require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $publish = isset($_POST['publish']) ? intval($_POST['publish']) : 0;

    if ($publish === 1) {
        // Set as Available and ensure it appears in store pages
        $stmt = $conn->prepare("UPDATE products SET availability='Available' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt = $conn->prepare("UPDATE products SET is_published = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "✅ Product published to store!";
        } else {
            echo "❌ Failed to publish.";
        }
    }
}
?>

 <?php
/*require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === "publish") {
        $stmt = $conn->prepare("UPDATE products SET is_published = 1 WHERE id = ?");
    } elseif ($action === "unpublish") {
        $stmt = $conn->prepare("UPDATE products SET is_published = 0 WHERE id = ?");
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
*/ ?> 