<?php
include("session-config.php");
$conn = new mysqli("localhost", "root", "", "collecticart");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MBH Products</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- Advertisement Banner -->
  <div class="ad-banner">
    MURAYTA ANG HANAP MO? CHECK MO 'TO! | <a href="deals-disc.php">SHOP SALE</a>
  </div>

  <!-- Main Menu -->
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
    <main>
      <h3>Mini Big Head (MBH)</h3>
      <div class="product-grid">
      <?php
      $conn = new mysqli("localhost", "root", "", "collecticart");
      $sql = "SELECT * FROM products WHERE page='products-mbh.php' AND is_published = 1 ORDER BY id DESC";
      $result = $conn->query($sql);

      // use prod-card, img-container commands in css to bring it back to proper formatting
      while($row = $result->fetch_assoc()) {

        echo '<div class="product-card">';
        echo '  <div class="img-container">';
        echo '    <a href="product_view.php?id='.$row['id'].'">';
        echo '    <img src="images/'.$row['image'].'" alt="'.$row['name'].'" />';
        echo '    </a>';

        // Wishlist button logic
        if (isset($_SESSION['user_id'])) {
            // Check if already wishlisted
            $user_id = $_SESSION['user_id'];
            $check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
            $check->bind_param("ii", $user_id, $row['id']);
            $check->execute();
            $wishRes = $check->get_result();
            $isWishlisted = $wishRes->num_rows > 0;

            echo '<form action="wishlist-toggle.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="product_id" value="'.$row['id'].'">';
            echo '<button type="submit" class="wishlist-btn'.($isWishlisted ? ' active' : '').'">♡</button>';
            echo '</form>';
        } else {
            // If not logged in → open login sidebar
            echo '<button class="wishlist-btn" onclick="openSidebar()">♡</button>';
        }

        echo '  </div>';
        echo '  <p class="brand">'.$row['brand'].'</p>';
        echo '  <p class="name">'.$row['name'].'</p>';
        echo '  <p class="price">₱'.$row['price'].'</p>';

        // Admin controls - pansamantala lang 
        /* echo '  <p>';
        echo '    <a href="crud-update_product.php?id='.$row['id'].'">✏️ Edit</a> | ';
        echo '    <a href="crud-delete_product.php?id='.$row['id'].'" onclick="return confirm(\'Are you sure?\')">🗑️ Delete</a>';
        echo '  </p>'; */

        echo '</div>'; 
      }
      ?>
      </div>  <!-- product-grid -->
  </main>
  </div> <!-- page-container -->

  <!-- Wishlist Login Sidebar -->
  <div id="loginSidebarOverlay" class="sidebar-overlay"></div>
  <div id="loginSidebar" class="sidebar-login">
  <div class="sidebar-header">
    <h2 id="sidebarTitle">Sign In</h2>
    <button id="closeSidebarBtn" class="close-btn">&times;</button>
  </div>

  <form id="loginForm" class="form-section" method="POST" action="login.php">
    <label>Username</label>
    <input type="text" name="username" placeholder="juan123" required>
    
    <label>Password</label>
    <input type="password" name="password" placeholder="••••••••" required>
    
    <button type="submit" class="sidebar-btn">Login</button>
    <p class="toggle-text">Don’t have an account? <span id="showSignup">Sign up</span></p>
  </form>

  <form id="signupForm" class="form-section hidden" method="POST" action="signup.php">
    <label>Full Name</label>
    <input type="text" name="fullname" placeholder="Juan Dela Cruz" required>
    
    <label>Username</label>
    <input type="text" name="username" placeholder="juan123" required>
    
    <label>Password</label>
    <input type="password" name="password" placeholder="••••••••" required>
    
    <button type="submit" class="sidebar-btn">Create Account</button>
    <p class="toggle-text">Already have an account? <span id="showLogin">Sign in</span></p>
  </form>
  </div>

  <!-- Floating Message Button -->
  <button class="message-btn">💬</button>

  <script src="script.js"></script>
</body>
</html>