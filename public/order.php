<?php
include "../includes/header.php";
include "../includes/connectdb.php";

if (!isset($_GET['id'])) {
    die("Order ID not found.");
}

// getting from orders
$order_id = intval($_GET['id']);
$orderquery = "SELECT * FROM orders WHERE order_id = $order_id";
$orderresult = mysqli_query($connection, $orderquery);

if (!$orderresult || mysqli_num_rows($orderresult) == 0) {
    die("Order query failed.");
}

$order = mysqli_fetch_assoc($orderresult);
$user_id=$_SESSION['user_id'];
?>
<div class="order-page">
    <h2 class="title">Order #<?php echo htmlspecialchars($order['order_id']);?> Details</h2>
    <div class="order-content">
        <div class="order-sectleft">
            <h5 class="order-header">Order ID: #<?php echo htmlspecialchars($order['order_id']);?></h5>
            <h5 class="order-header">Payment Method: <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $order['payment_method'])));;?></h5>
            <h5 class="order-header">Created: <?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($order['created_at'])));?></h5>
        </div>
        
        <div class="order-sectright">
            <h5 class="order-header">Total: $<?php echo htmlspecialchars(number_format($order['total_price'], 2)); ?></h5>
            <h5 class="order-header">Status: <?php echo htmlspecialchars(ucfirst($order['order_status']));?></h5>
        </div>
    </div>
    <hr/>
    <div class="order-details">
        <?php
        // getting from order_items
        $itemquery = "SELECT * FROM order_items WHERE order_id = $order_id";
        $itemresult = mysqli_query($connection, $itemquery);

        if (!$itemresult || mysqli_num_rows($itemresult) == 0) {
            die("Item query failed.");
        }

        while ($item = mysqli_fetch_assoc($itemresult)){ 
            // get product information for each item in order
            $product_id=$item['product_id'];
            $productquery = "SELECT * FROM products WHERE product_id = $product_id";
            $productresult = mysqli_query($connection, $productquery);

            if (!$productresult || mysqli_num_rows($productresult) == 0) {
                die("Product query failed.");
            }
            $product = mysqli_fetch_assoc($productresult);
            $product_subtotal=$product['price']*$item['quantity'];
            ?>
            <div class='cart-product'>
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div>
                    <h4 class='cart-product-title'><?php echo htmlspecialchars($product['name']); ?></h4>
                    <div class='cart-product-section'>
                        <p class='cart-price'>Price: <?php echo htmlspecialchars($product['price']); ?></p>
                        <p class='cart-quantity'>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                        <p class='cart-subtotal'>Subtotal: <?php echo htmlspecialchars($product_subtotal); ?></p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="order-link">
        <a href="shop.php">Continue Shopping</a>
        <a href="profile.php">Back to Profile</a>
    </div>
</div>
<?php include "../includes/footer.php"; ?>