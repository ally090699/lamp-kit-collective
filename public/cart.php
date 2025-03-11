<!-- Cart page -->
<?php include "../includes/header.php"?>
<h1 class="title">Cart</h1>
<div class='cart-container'>
    <div class='cart'>
        <?php 
        include "../includes/connectdb.php";
        $user_id = $_SESSION["user_id"];
        $error="";

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["place_order"])) {
        
            $cart_query = "SELECT c.product_id, c.quantity, p.price 
                           FROM cart c 
                           JOIN products p ON c.product_id = p.product_id 
                           WHERE c.user_id = $user_id";
            $cart_result = mysqli_query($connection, $cart_query);
        
            if (!$cart_result || mysqli_num_rows($cart_result) == 0) {
                $error="Error: Your cart is empty or cannot be processed.";
            } else {
                $cart_subtotal = 0;
                $order_items = [];
        
                while ($item = mysqli_fetch_assoc($cart_result)) {
                    $subtotal = $item["price"] * $item["quantity"];
                    $total_price += $subtotal;
                    $order_items[] = $item;
                }
        
                $hst = round($total_price * 0.13, 2);
                $shipping_fee = 3.99;
                $grand_total = round($total_price + $hst + $shipping_fee, 2);
        
                $order_query = "INSERT INTO orders (user_id, total_price, order_status, payment_method) 
                                VALUES ($user_id, $grand_total, 'pending', 'credit_card')";
                $order_result = mysqli_query($connection, $order_query);
        
                if ($order_result) {
                    $order_id = mysqli_insert_id($connection); // Get last inserted order ID
        
                    foreach ($order_items as $item) {
                        $insert_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                              VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})";
                        mysqli_query($connection, $insert_item_query);
                    }
        
                    $clear_cart_query = "DELETE FROM cart WHERE user_id = $user_id";
                    mysqli_query($connection, $clear_cart_query);
        
                    header("Location: confirm.php?order_id=$order_id");
                    exit();
                } else {
                    $error="Error: Could not place order.";
                }
            }
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
            $product_id = intval($_POST["product_id"]);
            $action = $_POST["action"];

            if ($action==="+"){
                $updatequery = "UPDATE cart SET quantity=quantity+1 WHERE user_id=$user_id AND product_id=$product_id";
            } else if ($action==="-"){
                $check_query = "SELECT quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id";
                $check_result = mysqli_query($connection, $check_query);
                $row = mysqli_fetch_assoc($check_result);

                if ($row["quantity"] > 1) {
                    $updatequery = "UPDATE cart SET quantity = quantity - 1 WHERE user_id = $user_id AND product_id = $product_id";
                } else {
                    $updatequery = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
                }
            }

            $updateresult = mysqli_query($connection, $updatequery);

            if (!$updateresult){
                die("Update quantity query failed.");
            }
        }

        $cart_subtotal=0;

        $query = "SELECT * FROM cart WHERE user_id = $user_id";
        $result = mysqli_query($connection, $query);

        if (!$result){
            die("Retrieving cart query failed.");
        }

        if (mysqli_num_rows($result)>0){
            while ($item=mysqli_fetch_assoc($result)){
                //for each product_id, need to get all product details
                $product_id=$item['product_id'];
                $productquery = "SELECT * FROM products WHERE product_id = $product_id";
                $productresult = mysqli_query($connection, $productquery);

                if (!$productresult || mysqli_num_rows($productresult) == 0){
                    continue;
                }

                $product=mysqli_fetch_assoc($productresult);
                $product_subtotal=$product['price']*$item['quantity'];
                ?>

                <div class='cart-product'>
                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div>
                        <h4 class='cart-product-title'><?php echo htmlspecialchars($product['name']); ?></h4>
                        <div class='cart-product-section'>
                            <p class='cart-price'>Price: <?php echo htmlspecialchars($product['price']); ?></p>
                            <div class='cart-quantity'>
                                <p>Quantity: </p>
                                <div class='cart-quantity form'>
                                    <form action="cart.php" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="action" value="-">
                                        <button type="submit">-</button>
                                    </form>
                                    <p><?php echo htmlspecialchars($item['quantity']); ?></p>
                                    <form action="cart.php" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="action" value="+">
                                        <button type="submit">+</button>
                                    </form>
                                </div>
                            </div>
                            <p class='cart-subtotal'>Subtotal: <?php echo htmlspecialchars($product_subtotal); ?></p>
                        </div>
                    </div>
                </div>

                <?php
                $cart_subtotal = $cart_subtotal+$product_subtotal;
            }
        } else {
            echo "
            <div class='cart-empty'>
                <h3>Your cart is empty.<h3>
                <p>Looks like you haven't added anything yet.</p>
                <a href='/lamp-kit-collective/public/shop.php' class='browse-btn'>Start Shopping</a>
            </div>
            ";
        }
        $cart_subtotal=round($cart_subtotal, 2);
        $hst=round($cart_subtotal*(0.13), 2);
        $shipping_fee=3.99;
        $grand_total=round($cart_subtotal + $hst + $shipping_fee, 2);
        ?>
    </div>
    <div class="cart-details">
        <p class="cart-details-header">Subtotal: <?php echo htmlspecialchars($cart_subtotal); ?></p>
        <p class="cart-details-header">HST (13%): <?php echo htmlspecialchars($hst); ?></p>
        <p class="cart-details-header">Shipping Fee: <?php echo htmlspecialchars($shipping_fee); ?></p>
        <p class="cart-details-header">Total: <?php echo htmlspecialchars($grand_total); ?></p>
        <?php if ($cart_subtotal > 0) { ?>
            <form action="cart.php" method="post">
                <input type="hidden" name="place_order" value="1">
                <button type="submit" class="place-order-btn">Place Order</button>
            </form>
        <?php } ?>
    </div>
</div>
 <?php include "../includes/footer.php"?>
