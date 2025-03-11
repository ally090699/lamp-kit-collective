<!-- Shop page -->
<?php include "../includes/header.php"?>
<div class="product-main">
    <h1 class="title">Browse Our Shop!</h1>
    <?php 
    include "../includes/connectdb.php";

    $error="";

    if (!isset($_SESSION["user_id"])) {
        $error = "You must be logged in to add items to the cart.";
        header("Location: login.php");
        exit;
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["product_id"]) || empty($_POST["quantity"])) {
            $error = "Error: Shop post request failed.";
            exit;
        }
    
        $user_id=$_SESSION["user_id"];
        $product_id=intval($_POST["product_id"]);
        $quantity=intval($_POST["quantity"]);

        // check if item already exists in the user's cart
        $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update quantity if product exists in cart
            $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
            $update_result = mysqli_query($connection, $update_query);

            if (!$update_result){
                $error = "Database query update shop page failed.";
            }
        } else {
            $insert_query="INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
            $insert_result=mysqli_query($connection,$insert_query);

            if (!$insert_result){
                $error = "Database query insert shop page failed.";
            }
        }
    }
    ?>
</div>
<div class='product-grid'>
<?php 
    $query = "SELECT * FROM products";
    $result = mysqli_query($connection, $query);

    if (!$result){
        $error="Error retrieving products.";
        exit;
    }

    while ($product = mysqli_fetch_assoc($result)){
        ?>
        <div class='product-card' onclick="window.location.href='product.php?id=<?php echo $product['product_id']; ?>'">
            <img class='product-card-img'
            src='<?php echo htmlspecialchars($product['image_url']); ?>'
            alt='Crochet <?php echo htmlspecialchars($product['name']); ?>'
            />
            <div>
            <h5 class='product-card-name'><?php echo htmlspecialchars($product['name']); ?></h5>
            <h5 class='product-card-price'><?php echo htmlspecialchars($product['price']); ?></h5>
            </div>
            <div class='product-card-btndiv'>
                <form action="shop.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button class='product-card-btn'>Add to Cart</button>
                </form>
            </div>
        </div>
        <?php
    }


    mysqli_free_result($result);
?>
</div>
<p class='error-statement'><?php if ($error) {echo htmlspecialchars($error);} ?></p>
 <?php include "../includes/footer.php"?>
