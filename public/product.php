<?php
include "../includes/header.php";
include "../includes/connectdb.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["user_id"])) {
        $error = "Error: You must be logged in to add items to your cart.";
    } else {
        $product_id = intval($_POST['product_id']);
        $user_id = $_SESSION["user_id"];
        $quantity = intval($_POST["quantity"]);

        // Check if item exists in cart
        $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
        $check_result = mysqli_query($connection, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Update quantity
            $update_query = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
            if (!mysqli_query($connection, $update_query)) {
                $error = "Error updating cart.";
            }
        } else {
            // Insert new item
            $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
            if (!mysqli_query($connection, $insert_query)) {
                $error = "Error adding item to cart.";
            }
        }
    }
}

// Fetch product data
if (!isset($_GET['id'])) {
    die("Product not found.");
}

$product_id = intval($_GET['id']);
$query = "SELECT * FROM products WHERE product_id = $product_id";
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($result);
$productcat = $product['category_id'];

if ($productcat) {
    $catquery = "SELECT * FROM categories WHERE category_id = $productcat";
    $catresult = mysqli_query($connection, $catquery);
    if (!$catresult || mysqli_num_rows($catresult) == 0) {
        die("Category not found.");
    }
    $category = mysqli_fetch_assoc($catresult);
}
?>

<div class="product-content">
    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
         alt="Product <?php echo htmlspecialchars($product['name']); ?>" 
         class="product-image"/>
    
    <div class="product-container">
        <div class="product-section">
            <div class="product-sectmain">
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="product-header"><?php echo htmlspecialchars($category['category_name']); ?></p>
            </div>
            <div class="product-sectinfo">
                <p class="product-price">$<?php echo htmlspecialchars($product['price']); ?></p>
                <p class="product-header">SKU: <?php echo htmlspecialchars($product['sku']); ?></p>
            </div>
        </div>
        <p class="product-details"><?php echo htmlspecialchars($product['description']); ?></p>
        
        <div class='product-page-btndiv'>
            <form action="product.php?id=<?php echo $product_id; ?>" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="quantity" value="1">
                <button class='product-card-btn'>Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<p class='error-statement'><?php if ($error) { echo htmlspecialchars($error); } ?></p>

<?php include "../includes/footer.php"; ?>
