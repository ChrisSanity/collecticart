<?php
    $conn = new mysqli("localhost", "root", "", "collecticart");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Awewa's ToyHub - Your ultimate destination for authentic One Piece and Dragon Ball Z collectible figures. Premium anime figures, limited editions, and rare finds in the Philippines.">
    <meta name="keywords" content="Authentic One Piece, Dragon Ball Z Figures, and Anime Collectibles">
    <meta name="author" content="Awewa's ToyHub">
    <meta property="og:title" content="Awewa's ToyHub - Premium Anime Collectible Figures">
    <meta property="og:type" content="website">
    <title>Awewa's ToyHub - Premium Anime Collectible Figures | One Piece & Dragon Ball Z</title>
    <link rel="stylesheet" href="style_landing.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <a href="home.php">CollectiCart</a>
                </div>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link active">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a href="all-products.php" class="nav-link">PRODUCTS</a>
                    </li>
                    <li class="nav-item">
                        <a href="deals-disc.php" class="nav-link">DEALS & DISCOUNTS</a>
                    </li>
                    <li class="nav-item">
                        <a href="reviews.php" class="nav-link">REVIEWS</a>
                    </li>
                    <li class="nav-item">
                        <a href="#footer-section" class="nav-link">CONTACT</a>
                    </li>
                </ul>
                <div class="nav-actions">
                <!--<a href="#" class="nav-icon"><i class="fas fa-search"></i></a>
                    <a href="#" class="nav-icon"><i class="fas fa-heart"></i></a>
                    <a href="#" class="nav-icon"><i class="fas fa-shopping-bag"></i></a> -->
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-image">
                <img src="images/mbh_strawhat_crew.jpg" alt="One Piece Collectible Figures Collection" class="hero-bg"> 
                <div class="hero-overlay"></div>
            </div>
            <div class="hero-content">
                <h1>Welcome to Awewa's ToyHub</h1>
                <a href="all-products.php" class="cta-button">Shop Now</a>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="categories">
            <div class="container">
                <h2>Shop by Category</h2>
                <div class="category-grid">
                    <article class="category-card">
                        <div class="category-image">
                            <img src="images/limited-luffy.jpg" alt="One Piece Figures">
                        </div>
                        <div class="category-content">
                            <h3>ONE PIECE</h3>
                            <p>One Piece character figures</p>
                            <a href="products-wcf.php" class="category-link">Shop Now</a>
                        </div>
                    </article>
                    <article class="category-card">
                        <div class="category-image">
                            <img src="images/dbz-box.jpg" alt="Dragon Ball Z Figures">
                        </div>
                        <div class="category-content">
                            <h3>DRAGON BALL Z</h3>
                            <p>Dragon Ball Z character figures</p>
                            <a href="products-dbz.php" class="category-link">Shop Now</a>
                        </div>
                    </article>
                    <article class="category-card">
                        <div class="category-image">
                            <img src="images/limited-luffyresin.jpg" alt="Limited Edition Figures">
                        </div>
                        <div class="category-content">
                            <h3>LIMITED EDITION</h3>
                            <p>Rare and exclusive figures</p>
                            <a href="products-limited.php" class="category-link">Shop Now</a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section class="featured-products">
            <div class="container">
                <h2>Featured Products</h2>
                <div class="product-grid">
                    <article class="product-card">
                        <div class="product-image">
                            <img src="images/bwfc-zoro.jpg" alt="Zoro">
                            <div class="product-actions">
                                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                                <button class="quick-view-btn">Quick View</button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>BWFC Zoro Wano</h3>
                            <p class="price">₱2,800.00</p>
                            <button class="add-to-cart">Add to Cart</button>
                        </div>
                    </article>
                    <article class="product-card">
                        <div class="product-image">
                            <img src="images/boats-sunnybig.jpg" alt="Sunny">
                            <div class="product-actions">
                                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                                <button class="quick-view-btn">Quick View</button>
                            </div>
                        </div>
                        <div class="product-info">  
                            <h3>DXF Sunny</h3>
                            <p class="price">₱1,500.00</p>
                            <button class="add-to-cart">Add to Cart</button>
                        </div>
                    </article>
                    <article class="product-card">
                        <div class="product-image">
                            <img src="images/dbz-vegeta.jpg" alt="Vegeta">
                            <div class="product-actions">
                                <button class="wishlist-btn"><i class="far fa-heart"></i></button>
                                <button class="quick-view-btn">Quick View</button>
                            </div>
                        </div>
                        <div class="product-info">
                            <h3>Grandista Vegeta</h3>
                            <p class="price">₱2,000.00</p>
                            <button class="add-to-cart">Add to Cart</button>
                        </div>
                    </article>
                </div>
            </div>
        </section>


        <!-- Special Offers -->
        <section class="special-offers">
            <div class="container">
                <h2>Special Offers</h2>
                <div class="offers-grid">
                    <article class="offer-card">
                        <i class="fas fa-shipping-fast"></i>
                        <h3>Free Shipping</h3>
                        <p>On orders over ₱2,000</p>
                    </article>
                    <article class="offer-card">
                        <i class="fas fa-percentage"></i>
                        <h3>5% Off</h3>
                        <p>First time collectors</p>
                    </article>
                    <article class="offer-card">
                        <i class="fas fa-undo"></i>
                        <h3>Free Keychains</h3>
                        <p>and other freebies</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class, id="footer-section">
                    <h3>Awewa's ToyHub</h3>
                    <p>Your ultimate destination for authentic collectible figures and rare finds.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/profile.php?id=100064104664957"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="all-products.php">Products</a></li>
                        <li><a href="deals-disc.php">Deals</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#footer-section">Contact Us</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <p><i class="fas fa-phone"></i> +63 905-755-8711</p>
                    <p><i class="fas fa-envelope"></i> awewastoyhub@gmail.com</p>
                    <p><i class="fas fa-map-marker-alt"></i> Tierra Subd., Brgy. Pulong Buhangin, Santa Maria, Bulacan</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Awewa's ToyHub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script_home.js"></script>
</body>
</html> 