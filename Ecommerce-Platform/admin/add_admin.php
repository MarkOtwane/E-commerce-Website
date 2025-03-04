<?php
session_start();
include '../db.php';

// Only the main admin can access this page
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'main_admin') {
    echo "Access Denied!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = 'sub_admin';

    // Check if email already exists
    $check_email = "SELECT * FROM admins WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "Email already registered!";
    } else {
        $sql = "INSERT INTO admins (full_name, email, password, role) VALUES ('$full_name', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Sub-Admin Added Successfully!";
            header("Location: manage_admins.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Sub-Admin</title>
</head>

<body>
    <h2>Add Sub-Admin</h2>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Add Admin</button>
    </form>
</body>

</html>