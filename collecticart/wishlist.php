<?php
include("session-config.php");
$conn = new mysqli("localhost", "root", "", "collecticart");

// If not logged in → remember this page and redirect to a page with login UI
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: all-products.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch wishlist products
$sql = "SELECT p.* FROM wishlist w 
        JOIN products p ON w.product_id = p.id 
        WHERE w.user_id = ? ORDER BY w.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Wishlist</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- Advertisement Banner -->
  <div class="ad-banner">
    ENJOY UP TO 50% OFF SELECTED TOYS | <a href="#">SHOP SALE</a>
  </div>

  <!-- Main Menu -->
  <header class="main-header">
    <nav>
      <ul class="menu-left">
        <li><a href="home.php">HOME</a></li>
        <li><a href="products-mbh.php">PRODUCTS</a></li>
        <li><a href="#">SALE</a></li>
        <li><a href="#">ABOUT</a></li>
      </ul>
    </nav>
    <div class="logo">Awewa's ToyHub Collecticart</div>
    <div class="menu-actions">
        <a href="wishlist.php" class="menu-icon"><i class="fas fa-heart"></i></a>
        <a href="#" class="menu-icon"><i class="fas fa-shopping-bag"></i></a>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="logout.php" class="menu-icon">Logout</a>
        <?php else: ?>
          <a href="javascript:void(0)" class="menu-icon" onclick="openSidebar()">Login</a>
        <?php endif; ?>
    </div>
  </header>

  <!-- Page Layout -->
  <div class="page-container">

    <!-- Sidebar -->
    <aside class="sidebar">
      <nav>
      <h4>CATEGORIES</h4>
      <ul class="categories">
        <li><a href="products-dbz.php">DRAGON BALL Z</a></li>
        <li><a href="products-mbh.php">MBH</a></li>
        <li><a href="products-wcf.php">WCF</a></li>
        <li><a href="products-gashapon.php">GASHAPON</a></li>
        <li><a href="products-collectibles.php">COLLECTIBLES</a></li>
        <li><a href="products-kchains.php">KEYCHAINS</a></li>
        <li><a href="products-set.php">SET</a></li>
        <li><a href="products-limited.php">LIMITED EDITION</a></li>
      </ul>
      </nav>
    </aside>

    <main>
      <h3>My Wishlist</h3>
      <div class="product-grid">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-card">
              <div class="img-container">
                <a href="product_view.php?id=<?php echo $row['id']; ?>">
                  <img src="images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                </a>
                <!-- Remove from wishlist button -->
                <form action="wishlist-remove.php" method="POST" style="position:absolute; top:10px; right:10px;">
                  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" class="wishlist-btn" style="color:red;">✖</button>
                </form>
              </div>
              <p class="brand"><?php echo htmlspecialchars($row['brand']); ?></p>
              <p class="name"><?php echo htmlspecialchars($row['name']); ?></p>
              <p class="price">₱<?php echo number_format($row['price'], 2); ?></p>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <p>You haven’t added any products to your wishlist yet.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>

</body>
</html>
