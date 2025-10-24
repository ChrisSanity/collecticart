<?php
require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brand = $_POST['brand'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $item_condition = $_POST['item_condition'];
    $stocks = $_POST['stocks'];
    $availability = $_POST['availability'];
    $page = $_POST['page']; 

    // Handle image upload
    $image = $_FILES["image"]["name"];
    $targetDir = "images/";
    $targetFile = $targetDir . basename($image);

    if (!empty($image)) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
    }

    // Insert query (with category now)
    $stmt = $conn->prepare("INSERT INTO products 
        (brand, name, price, description, item_condition, stocks, availability, image, page, is_published) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("ssdssisss", $brand, $name, $price, $description, $item_condition, $stocks, $availability, $image, $page);

    if ($stmt->execute()) {
        echo "✅ Product added successfully!";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
?>
