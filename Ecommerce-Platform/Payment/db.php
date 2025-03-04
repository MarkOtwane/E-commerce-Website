<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
};
?>

<!-- this file is working correctly their is no error in it -->