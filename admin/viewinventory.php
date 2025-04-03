<?php
include "../includes/header.php";
include "../includes/connectdb.php";
?>
<div class="flexcol main">
        <h1 class="title">View Inventory</h1>
        <form action="viewinventory.php" method="post">
                <input class="in-input" type="text" name="search" placeholder="Search inventory id, product name, sku..."/>
                <input class="in-btn" type="submit" value="Search">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST['search'])){
			include "includes/getinventory.php";
			while ($inv=mysqli_fetch_assoc($result)){
				$product_id=$inv['product_id'];
				$inventory_id=$inv['inventory_id'];
				$productquery="SELECT * FROM products WHERE product_id=$product_id";
				$productresult=mysqli_query($connection, $productquery);
				if (!$productresult){
					die("Product query failed.");
				}
				$product=mysqli_fetch_assoc($productresult);
	?>
				<div class="card">
                        		<h4><b>Inventory ID: </b><?php echo $inventory_id; ?></h4>
                        		<p><b>Product Name:</b> <?php echo $product['name']; ?></p>
					<p><b>Product SKU:</b> <?php echo $product['sku']; ?></p>
                        		<p><b>Stock Quantity:</b> <?php echo $inv['stock_quantity']; ?></p>
                        		<p><b>Last Updated:</b> <?php echo date("F j, Y, g:i A", strtotime($inv['last_updated'])); ?></p>
                		</div>
	<?php
			}
       		} else {
			$search = $_POST['search'];
                	$query="SELECT * FROM inventory, products WHERE products.name LIKE '%$search%' OR inventory.inventory_id LIKE '%$search%' OR products.sku LIKE '%$search%'";
                	$result=mysqli_query($connection,$query);
			if (mysqli_num_rows($result) > 0) {
                		while($inv=mysqli_fetch_assoc($result)){
					$product_id=$inv['product_id'];
                                	$query="SELECT * FROM products WHERE product_id=$product_id";
                                	$result=mysqli_query($connection, $query);
                                	if (!$result){
                                	        die("Product query failed.");
                                	}
                                	$product=mysqli_fetch_assoc($result);
        ?>
                			<div class="card">
                        			<h4><b>Inventory ID: </b><?php echo $inv['inventory_id']; ?></h4>
                        			<p><b>Product Name:</b> <?php echo $product['name']; ?></p>
                        			<p><b>Product SKU:</b> <?php echo $product['sku']; ?></p>
                        			<p><b>Stock Quantity:</b> <?php echo $inv['stock_quantity']; ?></p>
                        			<p><b>Last Updated:</b> <?php echo date("F j, Y, g:i A", strtotime($inv['last_updated'])); ?></p>
                			</div>
        <?php 
				}
			} else {
	?>
				<div class="card">
					<p>No items in inventory matching your search.</p>
				</div>
	<?php
			}
		}
	}
	?>
        </div>
</div>


<?php 
include "../includes/footer.php"
?>
