<?php
session_start();
include '../db.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
//     header("Location: login.php");
//     exit();
// }

// Fetch Users
$user_sql = "SELECT * FROM users";
$users = $conn->query($user_sql);

// Fetch Transactions
$order_sql = "SELECT * FROM orders ORDER BY created_at DESC";
$orders = $conn->query($order_sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <h2>Admin Dashboard</h2>

    <h3>Users List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <?php if ($user['role'] != 'admin') { ?>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h3>Transaction History</h3>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Buyer ID</th>
            <th>Seller ID</th>
            <th>Product</th>
            <th>Price</th>
            <th>Platform Fee</th>
            <th>Seller Earnings</th>
            <th>Payment Method</th>
            <th>Date</th>
        </tr>
        <?php while ($order = $orders->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['buyer_id']; ?></td>
                <td><?php echo $order['seller_id']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td>$<?php echo $order['price']; ?></td>
                <td>$<?php echo $order['platform_fee']; ?></td>
                <td>$<?php echo $order['seller_earning']; ?></td>
                <td><?php echo $order['payment_method']; ?></td>
                <td><?php echo $order['created_at']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a href="index.php">Back to admin home page</a><br>
    <a href="logout.php">Logout</a>
</body>

</html>