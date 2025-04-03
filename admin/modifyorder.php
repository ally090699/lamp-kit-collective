<?php
include "../includes/header.php";
include "../includes/connectdb.php";
$error="";
?>

<div class="flexcol main center">
    <h1 class="title">Modify Order</h1>
    <form action="modifyorder.php" method="post" class="admin form">
        <div class="in-section">
            <label class="in-label">Order Id</label>
            <select name="order_id" required>
                <option value="">Select order here</option>
                <?php 
                include "includes/getorders.php";
                while ($order = mysqli_fetch_assoc($result)) {
                ?>
			<option value="<?php echo $order['order_id']; ?>">Order #<?php echo $order['order_id']; ?></option>
                <?php } ?>
            </select>
        </div>
	<input class="in-btn" type="submit" value="Select Order to Modify">
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
	$order_id=$_POST['order_id'];
?>	<h1 class-"title">Order #<?php echo $order_id; ?></h1>
<?php
	$query="SELECT * FROM order_items WHERE order_id=$order_id";
	$result=mysqli_query($connection, $query);
	if (!$result){
		$error="Failed to retrieve order items.";
	} else {
		while ($item=mysqli_fetch_assoc($result)){
			$product_id=$item['product_id'];
			$pquery="SELECT name FROM products WHERE product_id=$product_id";
			$presult=mysqli_query($connection, $pquery);
			if (!$presult){
				$error="Failed to retrieve product name.";
			}
			$product=mysqli_fetch_assoc($presult);
?>
			<div class="card">
				<h4><?php echo $product['name']; ?></h4>
				<h6>Price: $<?php echo $item['price']; ?></h6>
				<h6>Quantity: <?php echo $item['quantity']; ?></h6>
				<h6>Subtotal: $<?php echo $item['subtotal']; ?></h6>
			</div>
<?php		}
	}
} ?>
<?php
include "../includes/footer.php";
?>
