<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Home - Laundry App</title>
</head>
<body>
    <header>
        <h1>Welcome to Laundry Service</h1>
    </header>
    <div class="container">
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <p><a href="order.php">Place a New Order</a> | <a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
