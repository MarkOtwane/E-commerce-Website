<?php
$servername = "localhost";
$username = "root"; // username
$password = "";  //password
$database = "ECommerce"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
