<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'seller') {
    header("Location: login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];

// Fetch Sales
$sql = "SELECT * FROM orders WHERE seller_id='$seller_id' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Sales</title>
</head>

<body>
    <h2>Sales History</h2>

    <?php while ($order = $result->fetch_assoc()) { ?>
        <div>
            <strong>Product Sold:</strong> <?php echo $order['product_name']; ?><br>
            <strong>Price:</strong> $<?php echo $order['price']; ?><br>
            <strong>Platform Fee:</strong> $<?php echo $order['platform_fee']; ?><br>
            <strong>Your Earnings:</strong> $<?php echo $order['seller_earning']; ?><br>
            <strong>Payment Method:</strong> <?php echo $order['payment_method']; ?><br>
            <strong>Date:</strong> <?php echo $order['created_at']; ?><br>
        </div>
        <hr>
    <?php } ?>

    <a href="seller_dashboard.php">Back to Dashboard</a>
</body>

</html>