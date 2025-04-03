<?php
include "../includes/header.php";
include "../includes/connectdb.php";

$error="";
?>

<div class="flexcol main center">
        <h1 class="title">Modify Inventory</h1>
        <form action="modifyinventory.php" method="post" class="in-form admin form">
                <!-- <div class="in-section"> -->
                        <label class="in-label">Product Name</label>
			<select name="product_id">
				<option>Select product here</option>
<?php				include "includes/getproducts.php";
				while ($product=mysqli_fetch_assoc($result)){
?>
					<option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
<?php				} ?>
			</select>
                <!-- </div> -->
                <input class="in-btn" type="submit" value="Select Product">
        </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
        $product_id=$_POST['product_id'];
	
	$prodquery="SELECT name FROM products WHERE product_id=$product_id";
	$prodresult=mysqli_query($connection, $prodquery);
	if (!$prodresult){
		$error="Could not retrieve product name.";
	}
	$selectedproduct=mysqli_fetch_assoc($prodresult);
	$product_name=$selectedproduct['name'];
        
        $query="SELECT stock_quantity FROM inventory WHERE product_id='$product_id'";
        $result=mysqli_query($connection, $query);
        if (!$result){
                $error="Failed to retrieve current stock quantity.";
        } else {
                $row=mysqli_fetch_assoc($result);
		$current_stock = $row ? $row['stock_quantity'] : 0;
?>
		<form action="modifyinventory.php" method="post" class="in-form">
                	<h5>Selected product: <?php echo $product_name; ?></h5>
			<div class="in-section">
                        	<label class="in-label">Stock Quantity</label>
				<input class="in-input" name="stock_quantity" type="number" min="0" step="1" value="<?php echo $current_stock; ?>">
				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
			</div>
			<input class="in-btn" type="submit" value="Update Stock Quantity">
		</form>
<?php
        }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['stock_quantity']) && isset($_POST['product_id'])) {
	$stock_quantity=$_POST['stock_quantity'];
	$product_id=$_POST['product_id'];

	$checkQuery = "SELECT * FROM inventory WHERE product_id = $product_id";
        $checkResult = mysqli_query($connection, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $query = "UPDATE inventory SET stock_quantity = $stock_quantity WHERE product_id = $product_id";
        } else {
            $query = "INSERT INTO inventory (product_id, stock_quantity) VALUES ($product_id, $stock_quantity)";
        }

	$result=mysqli_query($connection, $query);
	if (!$result){
		$error="Update inventory failed.";
	} else {
		$error="Successfully updated inventory!";
		echo "<meta http-equiv='refresh' content='1'>";

	}
}
?>

	<?php if (!empty($error)) : ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

</div>

<?php
include "../includes/footer.php";
?>
