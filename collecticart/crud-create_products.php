<?php
include("session-config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Products - Admin</title>
  <link href="style-admin.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

    <!-- Title + Back Button -->
    <header class="page-header">
        <h3 class="dashboard-title">Add a New Product</h3>
        <button class="back-btn" onclick="history.back()">← Back</button>
    </header>

      <!-- Product Form -->
      <div class="form-container">
        <form action="crud-save_product.php" method="POST" enctype="multipart/form-data">

          <div class="form-group">
            <label>Brand</label>
            <input type="text" name="brand" required>
          </div>

          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" required>
          </div>

          <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" step="1" required>
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" required></textarea>
          </div>

          <div class="form-group">
            <label>Condition</label>
            <select name="item_condition" required>
              <option value="MISB">MISB</option>
              <option value="BIB">BIB</option>
              <option value="Loose">Loose</option>
              <option value="With Issue">With Issue</option>
            </select>
          </div>

          <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" required>
          </div>

          <div class="form-group">
            <label>Publish To</label>
            <select name="page" required>
              <option value="products-wcf.php">WCF</option>
              <option value="products-mbh.php">MBH</option>
              <option value="products-dbz.php">DBZ</option>
              <option value="products-gashapon.php">GASHAPON</option>
              <option value="products-kchains.php">KEYCHAINS</option>
              <option value="products-set.php">SET</option>
              <option value="products-limited.php">LIMITED</option>
              <option value="products-collectibles.php">COLLECTIBLES</option>
            </select>
          </div>

          <button type="submit" class="btn-submit">💾 Save Product</button>
        </form>
      </div>
    </main>
  </div>
</body>
</html>