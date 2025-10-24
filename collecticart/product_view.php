<?php
$conn = new mysqli("localhost", "root", "", "collecticart");

if (!isset($_GET['id'])) {
    echo "Invalid product.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    echo "Product not found.";
    exit;
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Details</title>
  <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      background: #fff8f0; 
      color: #333;
    }

    .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0px 2px 8px rgba(0,0,0,0.1);
    }

    .image img {
      width: 100%;
      border-radius: 10px;
      object-fit: cover;
    }

    .product-details h2 {
      margin: 0 0 10px;
      font-size: 22px;
      font-weight: 600;
    }

    .brand {
      font-size: 14px;
      color: #777;
      margin-bottom: 5px;
    }

    .price {
      font-size: 18px;
      color: #ff6f61;
      font-weight: bold;
      margin: 10px 0 20px;
    }

    .description, .condition {
      margin: 15px 0;
      font-size: 14px;
      line-height: 1.5;
    }

    .btn-back {
      display: inline-block;
      margin-top: 25px;
      background-color: #ff6f61;
      color: #fff;
      text-decoration: none;
      padding: 10px 18px;
      border-radius: 6px;
      font-size: 14px;
      font-weight: 600;
      transition: background-color 0.25s ease-in-out, transform 0.15s ease-in-out;
    }

    .btn-back:hover {
      background-color: #f25548;
      transform: translateY(-1px);
    }

    .btn-back:active {
      background-color: #d94a3f;
      transform: translateY(0);
    }

    @media(max-width: 768px) {
      .container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="image">
      <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-details">
      <p class="brand"><?php echo htmlspecialchars($product['brand']); ?></p>
      <h2><?php echo htmlspecialchars($product['name']); ?></h2>
      <p class="price">₱<?php echo number_format($product['price'], 2); ?></p>
      <div class="description">
        <strong>Description:</strong>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
      </div>
      <div class="item_condition">
        <strong>Condition:</strong>
        <p><?php echo htmlspecialchars($product['item_condition']); ?></p>
      </div>
      <a href="<?php echo htmlspecialchars($product['page']); ?>" class="btn-back">← Back to Products</a>
    </div>
  </div>

</body>
</html>