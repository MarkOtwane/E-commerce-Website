<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'buyer') {
    header("Location: login.php");
    exit();
}

$buyer_id = $_SESSION['user_id'];

// Fetch Orders
$sql = "SELECT * FROM orders WHERE buyer_id='$buyer_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Orders</title>
</head>

<body>
    <h2>My Order History</h2>

    <?php while ($order = $result->fetch_assoc()) { ?>
        <div>
            <strong>Product:</strong> <?php echo $order['product_name']; ?><br>
            <strong>Price:</strong> $<?php echo $order['price']; ?><br>
            <strong>Payment Method:</strong> <?php echo $order['payment_method']; ?><br>
            <strong>Date:</strong> <?php echo $order['created_at']; ?><br>
        </div>
        <hr>
    <?php } ?>

    <a href="buyer_home.php">Back to Shop</a>
</body>

</html>