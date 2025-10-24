<!-- SAVES PRODUCT TO DATABASE -->

<?php
include("database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $item_condition = $_POST['item_condition']; 
    $page  = $_POST['page'];

    // image upload
    $targetDir = "images/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

    // Insert into DB
    $sql = "INSERT INTO products (brand, name, price, description, item_condition, image, page) 
            VALUES ('$brand', '$name', '$price', '$description', '$item_condition', '$fileName', '$page')";

    if ($conn->query($sql) === TRUE) {
        // Redirect prevents double submit
        header("Location: " . $page . "?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>