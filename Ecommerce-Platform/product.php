<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "Product Not Found!";
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Product Not Found!";
    exit();
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $product['product_name']; ?></title>
</head>

<body>
    <h2><?php echo $product['product_name']; ?></h2>
    <img src="<?php echo $product['image_url']; ?>" width="400"><br>
    <p><strong>Category:</strong> <?php echo $product['category']; ?></p>
    <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
    <p><strong>Price:</strong> $<?php echo $product['price']; ?></p>
    <a href="../Ecommerce-Platform/users/login.php?id=<?php echo $product['id']; ?>">Buy Now</a> <!---correction made--->
</body>

</html>