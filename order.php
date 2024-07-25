<?php
session_start();
require 'db/config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'customer') {
    header('Location: login.php');
    exit();
}

// Get user ID from the session username
$username = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
$user_id = $user['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $order_date = $_POST['order_date'];

    $sql = "INSERT INTO orders (user_id, address, order_date) VALUES ('$user_id', '$address', '$order_date')";
    if ($conn->query($sql) === TRUE) {
        $success = "Order placed successfully.";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>New Order - Laundry App</title>
</head>
<body>
    <header>
        <h1>Place a New Order</h1>
    </header>
    <div class="container">
        <form method="POST" action="">
            <textarea name="address" placeholder="Enter your address" required></textarea>
            <input type="date" name="order_date" required>
            <input type="submit" value="Place Order">
        </form>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <p><a href="index.php">Back to Home</a></p>
    </div>
</body>
</html>
