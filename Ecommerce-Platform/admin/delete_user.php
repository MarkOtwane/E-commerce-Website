<?php
session_start();
include '../db.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
//     header("Location: login.php");
//     exit();
// }

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prevent Admin Deletion
    $check_sql = "SELECT role FROM users WHERE id='$user_id'";
    $check_result = $conn->query($check_sql);
    $row = $check_result->fetch_assoc();

    if ($row['role'] == 'admin') {
        echo "Cannot delete an admin!";
    } else {
        $delete_sql = "DELETE FROM users WHERE id='$user_id'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "User deleted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

header("Location: index.php");
exit();
