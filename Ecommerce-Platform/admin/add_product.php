<?php
session_start();
include '../db.php';

// Only logged-in admins can add products
if (!isset($_SESSION['admin_id'])) {
    echo "Access Denied!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = $_SESSION['admin_id'];
    $category = $_POST['category'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Image Upload Handling
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "../assets/images" . basename($image); // Store in 'assets/images/'

    // Check if the file is an actual image
    // $imageFileType = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
    // $allowed_types = ['jpg', 'jpeg', 'png'];

    // if (!in_array($imageFileType, $allowed_types)) {
    //     die("Only JPG, JPEG, and PNG files are allowed.");
    // }

    // // Move the uploaded file to the correct folder
    // if (move_uploaded_file($image_tmp, "../" . $image_path)) {
    //     echo "File uploaded successfully!";
    // } else {
    //     die("Error uploading file.");
    // }

    // Store product details in the database
    $sql = "INSERT INTO products (admin_id, category, product_name, description, price, image_url) 
            VALUES ('$admin_id', '$category', '$product_name', '$description', '$price', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        echo "Product Added Successfully!";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
</head>

<body>
    <h2>Add Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="category" placeholder="Category" required><br>
        <input type="text" name="product_name" placeholder="Product Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" name="price" placeholder="Price" required><br>
        <input type="file" name="image" required><br>
        <button type="submit">Add Product</button>
    </form>

    <a href="index.php">Back to admin home page</a>
</body>

</html>