<?php
session_start();
include '../db.php';

// Only main admin can manage admins
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'main_admin') {
    echo "Access Denied!";
    exit();
}

// Fetch all admins
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Admins</title>
</head>

<body>
    <h2>Manage Admins</h2>
    <h3>Do want to add or delete the admin?</h3>
    <button><a href="add_admin.php">Add Admin</a></button>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php while ($admin = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $admin['id']; ?></td>
                <td><?php echo $admin['full_name']; ?></td>
                <td><?php echo $admin['email']; ?></td>
                <td><?php echo $admin['role']; ?></td>
                <td>
                    <?php if ($admin['role'] == 'sub_admin') { ?>
                        <a href="delete_admin.php?id=<?php echo $admin['id']; ?>">Delete</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="index.php">Back to admin home page</a>
</body>

</html>