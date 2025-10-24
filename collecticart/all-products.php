<?php
$conn = new mysqli("localhost", "root", "", "collecticart");
include("session-config.php");
// Fetch all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style-products.css">
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
                <li><a href="reviews.php">REVIEWS</a></li>
            </ul>
        </nav>
        <div class="logo">Awewa's ToyHub Collecticart</div>
        <div class="menu-actions">
            <!-- <a href="#" class="menu-icon"><i class="fas fa-search"></i></a> -->
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

    <!-- Page Container -->
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
        <main class="main-content">
            <div class="container">
                <h3>All Products</h3>
                
                <?php if ($result && $result->num_rows > 0): ?>
                <div class="products-grid">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <a href="product_view.php?id=<?php echo $row['id']; ?>">
                                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" 
                                        alt="<?php echo htmlspecialchars($row['name']); ?>">
                                </a>

                                <!-- Wishlist button logic -->
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <?php
                                    $user_id = $_SESSION['user_id'];
                                    $check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
                                    $check->bind_param("ii", $user_id, $row['id']);
                                    $check->execute();
                                    $wishRes = $check->get_result();
                                    $isWishlisted = $wishRes->num_rows > 0;
                                    ?>
                                    <form action="wishlist-toggle.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="wishlist-btn<?php echo $isWishlisted ? ' active' : ''; ?>">♡</button>
                                    </form>
                                <?php else: ?>
                                    <button class="wishlist-btn" onclick="openSidebar()">♡</button>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <p class="brand"><?php echo strtoupper(htmlspecialchars($row['brand'])); ?></p>
                                <h3 class="product-name"><?php echo strtoupper(htmlspecialchars($row['name'])); ?></h3>
                                <p class="price">₱<?php echo number_format($row['price'], 2); ?></p>
                                <a href="product_view.php?id=<?php echo $row['id']; ?>" class="view-btn">VIEW DETAILS</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                    <div class="no-products">
                        <p>NO PRODUCTS FOUND.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Wishlist Login Sidebar -->
    <div id="loginSidebarOverlay" class="sidebar-overlay"></div>
    <div id="loginSidebar" class="sidebar-login">
        <div class="sidebar-header">
            <h2 id="sidebarTitle">SIGN IN</h2>
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