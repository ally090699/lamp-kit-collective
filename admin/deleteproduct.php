<?php
include "../includes/header.php";
include "../includes/connectdb.php";
$error = "";
?>

<div class="flexcol main">
    <h1 class="title">Delete Product</h1>
    <form action="deleteproduct.php" method="post">
        <select name="selectedproduct">
            <option value="">Select product here</option>
            <?php 
            include "includes/getproducts.php";
            while ($product = mysqli_fetch_assoc($result)) {
            ?>
                <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
            <?php } ?>
        </select>
        <input class="in-btn" type="submit" value="Delete Product">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['selectedproduct'])) {
            echo '<div class="card"><p class="error">Error: Must select a product to delete.</p></div>';
        } else {
            $product_id = $_POST['selectedproduct'];
            
	    $checkOrderQuery = "SELECT COUNT(*) AS order_count FROM order_items WHERE product_id = $product_id";
            $checkOrderResult = mysqli_query($connection, $checkOrderQuery);
            $orderData = mysqli_fetch_assoc($checkOrderResult);
	    
	    if ($orderData['order_count'] > 0) {
                echo '<div class="card"><p class="error">Error: This product cannot be deleted because it is part of existing orders.</p></div>';
            } else {
	    	$query = "DELETE FROM products WHERE product_id=$product_id";
            	$result = mysqli_query($connection, $query);

            	if (!$result) {
            	    echo '<div class="card"><p class="error">Error deleting product.</p></div>';
            	} else {
            	    echo '<div class="card"><p class="success">Product successfully deleted!</p></div>';
            	    // Refresh the page after deletion to update product list
            	    echo "<meta http-equiv='refresh' content='1'>";
            	}
            }
    	}
    }
    ?>
</div>

<?php include "../includes/footer.php"; ?>
