<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password
    $role = 'main_admin'; // Default role for first admin

    // Check if an admin already exists
    $check_admin = "SELECT * FROM admins WHERE role='main_admin'";
    $result = $conn->query($check_admin);

    if ($result->num_rows > 0) {
        echo "A main admin already exists!";
    } else {
        $sql = "INSERT INTO admins (full_name, email, password, role) VALUES ('$full_name', '$email', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Main Admin Registered Successfully!";
            header("Location: login.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Registration</title>
</head>

<body>
    <h2>Register Main Admin</h2>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>