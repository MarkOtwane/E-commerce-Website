<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Image Upload Handling
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "../assets/images" . basename($image); // Store in 'assets/images/'

    // Check if the file is an actual image
    $imageFileType = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png'];

    if (!in_array($imageFileType, $allowed_types)) {
        die("Only JPG, JPEG, and PNG files are allowed.");
    }

    // Move the uploaded file to the correct folder
    if (move_uploaded_file($image_tmp, "../" . $image_path)) {
        echo "File uploaded successfully!";
    } else {
        die("Error uploading file.");
    }

    // Store product details in the database
    $sql = "INSERT INTO products (admin_id, category, product_name, description, price, image_url) 
            VALUES ('$admin_id', '$category', '$product_name', '$description', '$price', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch Seller Products
$sql = "SELECT * FROM products WHERE seller_id='$seller_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Seller Dashboard</title>
</head>

<body>
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?> (Seller)</h2>

    <h3>Add New Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="product_name" placeholder="Product Name" required><br>
        <input type="text" name="category" placeholder="Category" required><br>
        <textarea name="description" placeholder="Product Description" required></textarea><br>
        <input type="number" name="price" placeholder="Price" step="0.01" required><br>
        <input type="file" name="image" required><br>
        <button type="submit">Add Product</button>
    </form>

    <h3>Your Products</h3>
    <?php while ($product = $result->fetch_assoc()) { ?>
        <div>
            <img src="<?php echo $product['image_url']; ?>" width="100"><br>
            <strong><?php echo $product['product_name']; ?></strong><br>
            <?php echo $product['description']; ?><br>
            <strong>Price: </strong> $<?php echo $product['price']; ?><br>
            <a href="edit_product.php?id=<?php echo $product['id']; ?>">Edit</a> |
            <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
        </div>
        <hr>
    <?php } ?>

    <a href="logout.php">Logout</a>
</body>

</html>