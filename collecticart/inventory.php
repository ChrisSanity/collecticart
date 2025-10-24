<?php
require __DIR__ . "/session-config.php";
$conn = new mysqli("localhost", "root", "", "collecticart");

// Restrict access to admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: home.php");
    exit;
}


// Fetch products
$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inventory Management</title>
  <link rel="stylesheet" href="style-inventory.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">ADMIN</h2>
      <ul>
        <li><a href="admin-dashboard.php">Dashboard</a></li>
        <li><a href="crud-create_products.php">Products</a></li>
        <li><a href="inventory.php" class="active">Inventory</a></li>
        <li><a href="#">Discounts</a></li>
        <li><a href="#">Chats</a></li>
        <li><a href="#">Calendar</a></li>
        <li><a href="#">Reviews</a></li>
      </ul>
    </aside>

<main class="main-content">
  <div class="page-header">
    <h2 class="dashboard-title">Inventory Management</h2>
    <button id="addProductBtn" class="action-btn btn-publish">➕ Add Product</button>
  </div>

  <div class="inventory-container">
    <table class="inventory">
      <thead>
        <tr>
          <th>ID</th>
          <th>Brand</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stocks</th>
          <th>Availability</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr data-id="<?= $row['id'] ?>">
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['brand']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td>₱ <?= number_format($row['price'], 2) ?></td>
            <td>
              <input type="number" value="<?= $row['stocks'] ?>" min="0" class="stock-input">
            </td>
            <td>
              <select class="availability-select">
                <option value="Available" <?= $row['availability']=='Available'?'selected':'' ?>>Available</option>
                <option value="Sold" <?= $row['availability']=='Sold'?'selected':'' ?>>Sold</option>
                <option value="In Transit" <?= $row['availability']=='In Transit'?'selected':'' ?>>In Transit</option>
              </select>
            </td>
            <td>
              <button class="action-btn btn-edit">✏️ Edit</button>
              <button class="action-btn btn-save">💾 Save</button>
            <?php if ($row['is_published'] == 1): ?>
              <span class="published-label">✅ Published</span>
            <?php else: ?>
              <button class="action-btn btn-publish">🌐 Publish</button>
            <?php endif; ?>
              <button class="action-btn btn-delete">🗑️ Delete</button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Add Product Modal -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <h3>Add New Product</h3>
      <form id="addProductForm" enctype="multipart/form-data">
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
          <input type="number" name="price" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" required></textarea>
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
          <label>Stocks</label>
          <input type="number" name="stocks" min="0" required>
        </div>
        <div class="form-group">
          <label>Availability</label>
          <select name="availability" required>
            <option value="Available">Available</option>
            <option value="Sold">Sold</option>
            <option value="In Transit">In Transit</option>
          </select>
        </div>
        <div class="form-group">
          <label>Page</label>
          <select name="page" required>
            <option value="">-- Select Page --</option>
            <option value="products-dbz.php">Dragon Ball Z</option>
            <option value="products-mbh.php">MBH</option>
            <option value="products-wcf.php">WCF</option>
            <option value="products-gashapon.php">Gashapon</option>
            <option value="products-collectibles.php">Collectibles</option>
            <option value="products-kchains.php">Keychains</option>
            <option value="products-set.php">Set</option>
            <option value="products-limited.php">Limited Edition</option>
          </select>
        </div>
        <div class="form-group">
          <label>Image</label>
          <input type="file" name="image" required>
        </div>
        <div class="modal-actions">
          <button type="submit" class="action-btn btn-save">💾 Save Product</button>
          <button type="button" id="closeAddModal" class="action-btn">❌ Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Publish Modal (already exists) -->
  <div id="publishModal" class="modal">
    <div class="modal-content">
      <h3>Publish Product</h3>
      <p>Do you want to publish this product to the live store, or keep it in inventory only?</p>
      <div class="modal-actions">
        <button id="publishConfirm" class="action-btn btn-publish">🌐 Publish to Store</button>
        <button id="inventoryOnly" class="action-btn btn-save">📦 Keep in Inventory Only</button>
        <button id="closeModal" class="action-btn">❌ Cancel</button>
      </div>
    </div>
  </div>
</main>

  </div>

  <script src="script-inventory.js"></script>

</body>
</html>
