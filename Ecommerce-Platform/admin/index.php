<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <header class="header">
        <a href="">Admin Dashboard</a>

        <div class="logout">
            <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
    </header>
    <h2>Welcome, <?php echo $_SESSION['admin_name']; ?> (<?php echo $_SESSION['role']; ?>)</h2>
    <!-- <a href="logout.php">Logout</a> -->

    <aside>
        <ul>
            <li><a href="manage_admins.php">Manage Admin</a></li>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="view_users.php">Users List</a></li>
            <li><a href="update_product.php">Edit Product</a></li>
        </ul>
    </aside>
</body>

</html>