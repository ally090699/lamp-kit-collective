<!-- Cart page -->
<?php include "../includes/header.php"?>
<h1 class="title">Cart</h1>
<div class='cart-container'>
    <div class='cart'>
        <?php 
        include "../includes/connectdb.php";
        $user_id = $_SESSION["user_id"];

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
        ?>
    </div>
    <div class="cart-details">
        <p class="cart-details-header">Subtotal</p>
        <p class="cart-details-header">HST (13%)</p>
        <p class="cart-details-header">Shipping Fee</p>
        <p class="cart-details-header">Total</p>
    </div>
</div>
 <?php include "../includes/footer.php"?>
