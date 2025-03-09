<?php
include "../includes/header.php";
include "../includes/connectdb.php";

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

if ($productcat){
    $catquery = "SELECT * FROM categories WHERE category_id = $productcat";
    $catresult = mysqli_query($connection, $catquery);

    if (!$catresult || mysqli_num_rows($catresult) == 0) {
        die("Category not found.");
    }

    $category = mysqli_fetch_assoc($catresult);
}

?>

<div class="product-content">
    <img src=<?php echo htmlspecialchars($product['image_url']);?> alt="Product <?php echo htmlspecialchars($product['name']);?>" class="product-image"/>
    <div class="product-container">
        <div class="product-section">
            <div class="product-sectmain">
                <h1 class="product-title"><?php echo htmlspecialchars($product['name']);?></h1>
                <p class="product-header"><?php echo htmlspecialchars($category['category_name']);?></p>
            </div>
            <div class="product-sectinfo">
                <p class="product-price"><?php echo htmlspecialchars($product['price']);?></p>
                <p class="product-header"><?php echo htmlspecialchars($product['sku']);?></p>
            </div>
        </div>
        <p class="product-details"><?php echo htmlspecialchars($product['description']);?></p>
        <div class='product-btndiv'>
            <button class='product-btn'>Add to Cart</button>
        </div>
    </div>
    
</div>
<?php include "../includes/footer.php"; ?>