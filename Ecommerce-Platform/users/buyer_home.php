<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'buyer') {
    header("Location: login.php");
    exit();
}

// Fetch Products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Shop</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="buyer.css">
</head>

<body>
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?> (Buyer)</h2>
    <h3>Available Products</h3>

    <?php while ($product = $result->fetch_assoc()) { ?>
        <div class="products_section">
            <div class="product">
                <div class="image">
                    <img src="<?php echo $product['image_url']; ?>" width="100"><br>
                </div>
                <div class="description">
                    <strong><?php echo $product['product_name']; ?></strong><br>
                    <?php echo $product['description']; ?><br>
                </div>
                <div class="price">
                    <strong>Price: </strong> $<?php echo $product['price']; ?><br>
                    <a href="../payments/buy_product.php?id=<?php echo $product['id']; ?>">Buy Now</a>
                </div>
            </div>
        </div>
        <br>
    <?php } ?>

    <a href="logout.php">Logout</a>
</body>

</html>