<?php
include("session-config.php");

$conn = new mysqli("localhost", "root", "", "collecticart");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products on sale
$sql = "SELECT * FROM products 
        WHERE sale_price IS NOT NULL 
        AND is_published = 1 
        AND availability = 'Available'
        ORDER BY (price - sale_price) DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Deals & Discounts - Collectibles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <style>
    .deals-content {
      flex: 1;
      padding: 40px;
      background: #fff8f0;
    }

    .deals-content h3 {
      font-size: 28px;
      font-weight: 700;
      color: #ff6f61;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-bottom: 3px solid #ff6f61;
      padding-bottom: 10px;
    }

    .deals-list {
      background: white;
      padding: 30px;
      border-radius: 10px;
      margin-bottom: 40px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }

    .deals-list ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .deals-list li {
      padding: 15px 0;
      border-bottom: 1px solid #f0f0f0;
      font-size: 15px;
      color: #444;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .deals-list li:last-child {
      border-bottom: none;
    }

    .deals-list li i {
      color: #ff6f61;
      font-size: 18px;
    }

    .discount-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      background: #ff6f61;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
      z-index: 10;
    }

    .original-price {
      text-decoration: line-through;
      color: #999;
      font-size: 12px;
      margin-right: 8px;
    }

    .sale-price {
      color: #ff6f61;
      font-weight: bold;
      font-size: 16px;
    }

    .no-products {
      text-align: center;
      padding: 40px;
      color: #999;
      font-size: 16px;
      background: white;
      border-radius: 10px;
    }
  </style>
</head>
<body>

  <!-- Advertisement Banner -->
  <div class="ad-banner">
    MURAYTA ANG HANAP MO? CHECK MO 'TO! | <a href="deals-disc.php">SHOP SALE</a>
  </div>

  <!-- Main Header -->
  <header class="main-header">
    <nav>
      <ul class="menu-left">
          <li><a href="home.php">HOME</a></li>
          <li><a href="all-products.php">PRODUCTS</a></li>
          <li><a href="deals-disc.php">DEALS</a></li>
      </ul>
    </nav>
    <div class="logo">Awewa's ToyHub Collecticart</div>
    <div class="menu-actions">
      <?php if (isset($_SESSION['user_id'])): ?>
          <a href="wishlist.php" class="menu-icon"><i class="fas fa-heart"></i></a>
      <?php else: ?>
          <a href="javascript:void(0)" class="menu-icon" onclick="openSidebar()">
              <i class="fas fa-heart"></i>
          </a>
      <?php endif; ?>
      <a href="#" class="menu-icon"><i class="fas fa-shopping-bag"></i></a>
      <!-- login -->
      <?php if (isset($_SESSION['user_id'])): ?>
          <a href="logout.php" class="menu-icon">Logout</a>
      <?php else: ?>
          <a href="javascript:void(0)" class="menu-icon" onclick="openSidebar()" title="Login"><i class="fas fa-user"></i></a>
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

    <!-- Main Content -->
    <main class="deals-content">
      <h3>DEALS</h3>
      <div class="deals-list">
        <ul>
          <li>
            <i class="fas fa-gift"></i>
            <span><strong>Free keychain</strong> for every purchase of MBH worth ₱1,000 or more.</span>
          </li>
          <li>
            <i class="fas fa-image"></i>
            <span><strong>Free poster</strong> for every purchase of 1 set of products (must be in Set categories).</span>
          </li>
          <li>
            <i class="fas fa-gavel"></i>
            <span>Check our <strong><a href="https://www.facebook.com/profile.php?id=100064104664957" target="_blank" style="color: #ff6f61; text-decoration: none;">Facebook page</a></strong> for daily biddings.</span>
          </li>
        </ul>
      </div>

      <h3>DISCOUNTS</h3>
      <?php if ($result && $result->num_rows > 0): ?>
        <div class="product-grid">
          <?php while($product = $result->fetch_assoc()): ?>
            <?php 
              $discount = round((($product['price'] - $product['sale_price']) / $product['price']) * 100);
            ?>
            <div class="product-card">
              <div class="img-container">
                <span class="discount-badge">-<?php echo $discount; ?>%</span>
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>">
                <?php if (isset($_SESSION['user_id'])): ?>
                  <button class="wishlist-btn" onclick="toggleWishlist(<?php echo $product['id']; ?>, this)">
                    <i class="fas fa-heart"></i>
                  </button>
                <?php endif; ?>
              </div>
              <div class="brand"><?php echo htmlspecialchars($product['brand']); ?></div>
              <div class="name"><?php echo htmlspecialchars($product['name']); ?></div>
              <div class="price">
                <span class="original-price">₱<?php echo number_format($product['price'], 2); ?></span>
                <span class="sale-price">₱<?php echo number_format($product['sale_price'], 2); ?></span>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="no-products">
          <i class="fas fa-tag" style="font-size: 48px; margin-bottom: 15px; color: #ddd;"></i>
          <p>No discounted products available at the moment. Check back soon!</p>
        </div>
      <?php endif; ?>
    </main>

  </div>

  <script>
    function toggleWishlist(productId, button) {
      // Add your wishlist toggle logic here
      console.log('Toggle wishlist for product:', productId);
    }
  </script>

</body>
</html>

<?php
$conn->close();
?>