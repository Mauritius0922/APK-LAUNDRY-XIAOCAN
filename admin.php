<?php
session_start();
require 'db/config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    $sql = "UPDATE orders SET status='$new_status' WHERE id='$order_id'";
    if ($conn->query($sql) === TRUE) {
        $success = "Order status updated successfully.";
    } else {
        $error = "Error updating status: " . $conn->error;
    }
}

$sql = "SELECT orders.id, users.username, orders.address, orders.order_date, orders.status 
        FROM orders 
        JOIN users ON orders.user_id = users.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Panel - Laundry App</title>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
    </header>
    <div class="container">
        <h2>Order List</h2>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Address</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['address']}</td>
                            <td>{$row['order_date']}</td>
                            <td>{$row['status']}</td>
                            <td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='order_id' value='{$row['id']}'>
                                    <select name='status'>
                                        <option value='pending'".($row['status'] == 'pending' ? ' selected' : '').">Pending</option>
                                        <option value='complete'".($row['status'] == 'complete' ? ' selected' : '').">Complete</option>
                                    </select>
                                    <input type='submit' value='Update'>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No orders found</td></tr>";
            }
            ?>
        </table>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
