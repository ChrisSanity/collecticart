<?php
include("session-config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}

// DB connection
$conn = new mysqli("localhost", "root", "", "collecticart");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id    = $_POST['id'];
    $brand = $_POST['brand'];
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $item_condition = $_POST['item_condition']; 
    $page  = $_POST['page'];

    // If new image is uploaded
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "images/";
        $fileName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);

        $sql = "UPDATE products 
                SET brand='$brand', name='$name', price='$price', description='$description', 
                    item_condition='$item_condition', image='$fileName', page='$page'
                WHERE id=$id";
    } else {
        $sql = "UPDATE products 
                SET brand='$brand', name='$name', price='$price', description='$description', 
                    item_condition='$item_condition', page='$page'
                WHERE id=$id";
    }

    $conn->query($sql);
    header("Location: " . $page . "?success=1"); 
    exit;
}

// If editing, fetch product
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Admin</title>
  <link rel="stylesheet" href="style-admin.css">
</head>
<body>
  <div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">ADMIN</h2>
      <ul>
        <li><a href="admin-dashboard.php">Dashboard</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Inventory</a></li>
        <li><a href="#">Discounts</a></li>
        <li><a href="#">Chats</a></li>
        <li><a href="#">Calendar</a></li>
        <li><a href="#">Wishlist</a></li>
        <li><a href="#">Reviews</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">

      <!-- Header -->
      <header class="page-header">
        <h3 class="dashboard-title">Edit a Product</h3>
        <button class="back-btn" onclick="history.back()">← Back</button>
      </header>

      <!-- Form -->
      <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $product['id'] ?>">

          <div class="form-group">
            <label>Brand</label>
            <input type="text" name="brand" value="<?= $product['brand'] ?>" required>
          </div>

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= $product['name'] ?>" required>
          </div>

          <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" step="1" value="<?= $product['price'] ?>" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" required><?= $product['description'] ?></textarea>
          </div>

          <div class="form-group">
            <label>Condition</label>
            <select name="item_condition" required>
              <option value="MISB" <?= $product['item_condition']=="MISB"?"selected":"" ?>>MISB</option>
              <option value="BIB" <?= $product['item_condition']=="BIB"?"selected":"" ?>>BIB</option>
              <option value="Loose" <?= $product['item_condition']=="Loose"?"selected":"" ?>>Loose</option>
              <option value="With Issue" <?= $product['item_condition']=="With Issue"?"selected":"" ?>>With Issue</option>
            </select>
          </div>

          <div class="form-group">
            <label>Image</label>
            <input type="file" name="image">
            <small>Current: <?= $product['image'] ?></small>
          </div>

          <div class="form-group">
            <label>Publish To</label>
            <select name="page" required>
              <option value="products-wcf.php" <?= $product['page']=="products-wcf.php"?"selected":"" ?>>WCF</option>
              <option value="products-mbh.php" <?= $product['page']=="products-mbh.php"?"selected":"" ?>>MBH</option>
              <option value="products-dbz.php" <?= $product['page']=="products-dbz.php"?"selected":"" ?>>DBZ</option>
              <option value="products-gashapon.php" <?= $product['page']=="products-gashapon.php"?"selected":"" ?>>GASHAPON</option>
              <option value="products-kchains.php" <?= $product['page']=="products-kchains.php"?"selected":"" ?>>KEYCHAINS</option>
              <option value="products-set.php" <?= $product['page']=="products-set.php"?"selected":"" ?>>SET</option>
              <option value="products-limited.php" <?= $product['page']=="products-limited.php"?"selected":"" ?>>LIMITED</option>
              <option value="products-collectibles.php" <?= $product['page']=="products-collectibles.php"?"selected":"" ?>>COLLECTIBLES</option>
            </select>
          </div>

          <button type="submit" class="btn-submit">✏️ Update Product</button>
        </form>
      </div>
    </main>
  </div>
</body>
</html>