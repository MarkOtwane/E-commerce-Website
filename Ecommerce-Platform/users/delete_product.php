<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// Ensure the seller owns this product
$sql = "DELETE FROM products WHERE id='$product_id' AND seller_id='$seller_id'";
if ($conn->query($sql) === TRUE) {
    echo "Product deleted successfully!";
} else {
    echo "Error: " . $conn->error;
}

header("Location: seller_dashboard.php");
