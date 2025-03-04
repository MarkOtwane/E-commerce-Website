<?php
session_start();

// If the cart is empty, redirect to the index page
if (!is_array($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

// Initialize total amount
$total = 0.0;

include('db.php');

foreach ($_SESSION['cart'] as $product_id) {
    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id); // Assuming product_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Calculate total price
    if ($product) {
        $total += $product['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Payment</h2>
<p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>

<!-- PayPal Button -->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="POST">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="otwanemark254@gmail.com">
    <input type="hidden" name="item_name" value="E-commerce Product">
    <input type="hidden" name="amount" value="<?php echo number_format($total, 2); ?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="http://localhost/payment_success.php">
    <input type="hidden" name="cancel_return" value="http://localhost/payment_cancel.php">
    <button type="submit">Pay with PayPal</button>
</form>

</body>
</html>
