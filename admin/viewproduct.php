<?php 
include "../includes/header.php";
include "../includes/connectdb.php";
?>

<div class="flexcol main">
        <h1 class="title">View Product</h1>
        <form action="viewproduct.php" method="post">
	        <select name="selectedproduct">
        	        <option value="">Select product here</option>
        	<?php 
        	include "includes/getproducts.php";
        	while ($product=mysqli_fetch_assoc($result)){
        	?>
        	        <option value="<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></option>
        	<?php } ?>
        	</select>
        	<input class="in-btn" type="submit" value="Select product">
	</form>

	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST['selectedproduct'])){
			include "includes/getproducts.php";
			while ($product=mysqli_fetch_assoc($result)){
				
	?>
				
				<div class="card">
                        		<h4><b><?php echo $product['name']; ?></b></h4>
                        		<p><b>Description:</b> <?php echo $product['description']; ?></p>
                        		<p><b>Price:</b> $<?php echo $product['price']; ?></p>
                        		<p><b>Category:</b> <?php echo $category['category_name']; ?></p>
                        		<p><b>Image:</b> </p>
                        		<img class="product-card-img" src="../public/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                        		<p><b>SKU:</b> <?php echo $product['sku']; ?></p>
                		</div>
	<?php
			}
		}
		$productid=$_POST['selectedproduct'];
		$query="SELECT * FROM products WHERE product_id=$productid";
		$result=mysqli_query($connection, $query);
		if (!$result){
			die("View selected product query failed.");
		}
		$product=mysqli_fetch_assoc($result);

		$categoryid=$product['category_id'];
		$query="SELECT category_name FROM categories WHERE category_id=$categoryid";
		$result=mysqli_query($connection, $query);
		if (!$result){
			die("Category name query failed.");
		}
		$category=mysqli_fetch_assoc($result);
	?>
		<div class="card">
			<h4><b><?php echo $product['name']; ?></b></h4>
			<p><b>Description:</b> <?php echo $product['description']; ?></p>
			<p><b>Price:</b> $<?php echo $product['price']; ?></p>
			<p><b>Category:</b> <?php echo $category['category_name']; ?></p>
			<p><b>Image:</b> </p>
			<img class="product-card-img" src="../public/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
			<p><b>SKU:</b> <?php echo $product['sku']; ?></p>
		</div>
	<?php } ?>
	</div>
</div>

<?php
include "../includes/footer.php";
?>
