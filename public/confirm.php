<?php include "../includes/header.php"; ?>
<?php include "../includes/connectdb.php"; ?>

<?php
    if (!isset($_GET["order_id"])) {
        echo "<h2>Error: Order not found.</h2>";
        exit();
    }

    $order_id = intval($_GET["order_id"]);
    $user_id = $_SESSION["user_id"];

    $order_query = "SELECT * FROM orders WHERE order_id = $order_id AND user_id = $user_id";
    $order_result = mysqli_query($connection, $order_query);

    if (!$order_result || mysqli_num_rows($order_result) == 0) {
        echo "<h2>Error: Order not found.</h2>";
        exit();
    }

    $order = mysqli_fetch_assoc($order_result);
?>

<div class="confirm-page">
    <h1 class="title">Thank you for your order!</h1>
    <p class="subtitle">Your order ID is <strong>#<?php echo $order["order_id"]; ?></strong></p>
    <p class="subtitle">Total: <strong>$<?php echo htmlspecialchars($order["total_price"]); ?></strong></p>
    <p class="subtitle">Status: <strong><?php echo htmlspecialchars(ucfirst($order["order_status"])); ?></strong></p>
    <a href="shop.php">Continue Shopping</a>
</div>


<?php include "../includes/footer.php"; ?>
