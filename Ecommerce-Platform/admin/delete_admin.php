<?php
session_start();
include '../db.php';

// Only main admin can delete sub-admins
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'main_admin') {
    echo "Access Denied!";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ensure it's not a main admin being deleted
    $sql = "SELECT * FROM admins WHERE id=$id AND role='sub_admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $delete_sql = "DELETE FROM admins WHERE id=$id";
        $conn->query($delete_sql);
        echo "Sub-Admin Deleted!";
        header("Location: manage_admins.php");
    } else {
        echo "Invalid Request!";
    }
}
