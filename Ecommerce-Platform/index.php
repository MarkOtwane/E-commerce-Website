<?php
include 'db.php';

// Fetch all products
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

$where = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $where = "WHERE product_name LIKE '%$search%' OR category LIKE '%$search%'";
}

$sql = "SELECT * FROM products $where ORDER BY created_at DESC";

?>

<!DOCTYPE html>
<html>

<head>
    <title>Home - E-Commerce</title>
    <style>
        .product {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            width: 250px;
            text-align: center;
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <form method="GET">
        <input type="text" name="search" placeholder="Search products...">
        <button type="submit">Search</button>
    </form>
    <h2>Available Products</h2>
    <div class="products">
        <?php while ($product = $result->fetch_assoc()) { ?>
            <div class="product">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>">
                <h3><?php echo $product['product_name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p><strong>Price: </strong>$<?php echo $product['price']; ?></p>
                <a href="product.php?id=<?php echo $product['id']; ?>">View More</a>
            </div>
        <?php } ?>
    </div>


</body>

</html>