<?php
session_start();

// Simulating payment success (we can add real payment gateway integration later)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    
    // Process the payment (this is just a simulation)
    echo "<h2>Payment Successful</h2>";
    echo "<p>Thank you for your order! Your payment via " . $payment_method . " has been successfully processed.</p>";
    
    // Clear the cart after payment
    unset($_SESSION['cart']);
}
?>