<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $location = $_POST['location'];
    $role = $_POST['role'];

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($check_email);

    if ($result->num_rows > 0) {
        echo "Email already registered!";
    } else {
        $sql = "INSERT INTO users (first_name, last_name, email, password, location, role) 
                VALUES ('$first_name', '$last_name', '$email', '$password', '$location', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "Signup successful!";
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
    <title>Signup</title>
</head>

<body>
    <h2>User Signup</h2>
    <form method="POST">
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="location" placeholder="Location" required><br>
        <select name="role">
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
        </select><br>
        <button type="submit">Signup</button>
    </form>
    <a href="login.php">Login if already have an account</a>
</body>

</html>