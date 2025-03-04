<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'buyer') {
    header("Location: login.php");
    exit();
}

$product_id = $_GET['id'];

// Validate Product ID
if (!filter_var($product_id, FILTER_VALIDATE_INT)) {
    echo "Invalid product ID!";
    exit();
}

// Fetch Product
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Product not found!";
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    $buyer_id = $_SESSION['user_id'];
    $seller_id = $product['seller_id'];
    $product_name = $product['product_name'];
    $price = $product['price'];

    // Deduct 25% Commission
    $platform_fee = $price * 0.25;
    $seller_earning = $price - $platform_fee;

    // Simulate Payment Processing
    simulatePayment($payment_method, $price);

    // Save Order in Database
    $order_sql = "INSERT INTO orders (buyer_id, seller_id, product_name, price, platform_fee, seller_earning, payment_method) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($order_sql);
    $stmt->bind_param("iisddds", $buyer_id, $seller_id, $product_name, $price, $platform_fee, $seller_earning, $payment_method);

    if ($stmt->execute()) {
        $stmt->close();

        // Remove Product After Purchase
        $delete_sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            $stmt->close();
            echo "<h3>Payment successful! Your order has been placed.</h3>";
            exit();
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    } else {
        echo "Error placing order: " . $conn->error;
    }

    $stmt->close();
    exit();
}

function simulatePayment($method, $amount)
{
    switch ($method) {
        case "bank":
            echo "[SIMULATION] Bank transfer of $" . number_format($amount, 2) . " completed.";
            break;
        case "credit_card":
            echo "[SIMULATION] Credit card payment of $" . number_format($amount, 2) . " successful.";
            break;
        case "paypal":
            echo "[SIMULATION] PayPal transaction of $" . number_format($amount, 2) . " processed.";
            break;
        case "stripe":
            echo "[SIMULATION] Stripe payment of $" . number_format($amount, 2) . " successful.";
            break;
        case "mpesa":
            echo "[SIMULATION] M-Pesa transaction of $" . number_format($amount, 2) . " completed.";
            break;
        default:
            echo "Invalid payment method.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Payment</title>
</head>

<body>
    <h2>Confirm Purchase</h2>
    <strong>Product: </strong> <?php echo htmlspecialchars($product['product_name']); ?><br>
    <strong>Price: </strong> $<?php echo number_format($product['price'], 2); ?><br>

    <h3>Select Payment Method</h3>
    <form method="POST">
        <select name="payment_method" required>
            <option value="mpesa">M-Pesa</option>
            <option value="bank">Bank Transfer</option>
            <option value="credit_card">Credit Card</option>
            <option value="paypal">PayPal</option>
            <option value="stripe">Stripe</option>
        </select><br>
        <button type="submit">Pay Now</button>
    </form>
</body>

</html>