<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// Fetch Product
$sql = "SELECT * FROM products WHERE id='$product_id' AND seller_id='$seller_id'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    echo "Product not found!";
    exit();
}

$product = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Image Handling (Optional)
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "uploads/" . basename($image);
        move_uploaded_file($image_tmp, $image_path);

        $sql = "UPDATE products SET 
                product_name='$product_name', category='$category', description='$description', 
                price='$price', image_url='$image_path' WHERE id='$product_id'";
    } else {
        $sql = "UPDATE products SET 
                product_name='$product_name', category='$category', description='$description', 
                price='$price' WHERE id='$product_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product</title>
</head>

<body>
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>
        <input type="text" name="category" value="<?php echo $product['category']; ?>" required><br>
        <textarea name="description" required><?php echo $product['description']; ?></textarea><br>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required><br>
        <input type="file" name="image"><br>
        <button type="submit">Update Product</button>
    </form>
    <a href="seller_dashboard.php">Back</a>
</body>

</html>