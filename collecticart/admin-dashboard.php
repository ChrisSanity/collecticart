<?php
include "session-config.php";

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
  <title>Admin Dashboard</title>
  <link href="style-admin.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<body>
  <div class="container">

    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="logo">ADMIN</h2>
      <ul>
        <li><a href="admin-dashboard.php">Dashboard</a></li>
        <li><a href="products-dbz.php">Products</a></li>
        <li><a href="inventory.php">Inventory</a></li>
        <li><a href="deals-disc.php">Discounts</a></li>
        <li><a href="admin-chat.php">Chats</a></li>
        <li><a href="#">Calendar</a></li>
        <li><a href="#">Reviews</a></li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      
<!--       Header
      <header class="header">
        <div class="search-box">
          <input type="text" placeholder="Search...">
          <button>Search</button>
        </div>
      </header> -->

      <h3 class="dashboard-title">Admin Dashboard</h3>

      <!-- Boxes -->
      <div class="box-container">
        <!-- <div class="box"><a href="#">Calendar</a></div> -->
        <div class="box products-box">
          <div class="cover-photo">
            <img src="images/calendar.jpg" alt="Calendar">
          </div>
          <h4>Calendar</h4>
        </div>
        <!-- Enhanced Products Box -->
        <div class="box products-box">
          <div class="cover-photo">
            <img src="images/logo.jpg" alt="Products">
          </div>
          <div class="overlay">
            <a href="crud-create_products.php">➕ Publish a Product</a>
            <a href="products-mbh.php">✏️ Edit a Product</a>
            <a href="products-wcf.php">🗑️ Delete a Product</a>
          </div>
          <h4>Products</h4>
        </div>

        <div class="box"><a href="#">Inventory</a></div>
      </div>


      <!-- Graphs -->
      <div class="graph-container">
        <div class="graph" id="barGraph"></div>
        <div class="graph" id="lineGraph"></div>
        <div class="graph" id="areaGraph"></div>
      </div>

    </main>
  </div>

  <script src="script-admin.js"></script>
</body>
</html>