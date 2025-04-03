<?php
include "../includes/header.php";
include "../includes/connectdb.php";
$error="";
?>

<div class="flexcol main">
        <h1 class="title">Modify Product</h1>
        <form action="modifyproduct.php" method="post">
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
	<p><?php if (!empty($error)){ echo $error; } else { echo ""; }; ?></p>

	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
                $productid = $_GET['id'];
                $query="SELECT * FROM products WHERE product_id=$productid";
                $result=mysqli_query($connection, $query);
                $product=mysqli_fetch_assoc($result);
                
		if (!$product){
                        $error="Error retrieving product.";
                }
                
                $newName = $_POST['name'] ?: $product['name'];
                $newDesc = $_POST['description'] ?: $product['description'];
                $newPrice = $_POST['price'] ?: $product['price'];
                $newSku = $_POST['sku'] ?: $product['sku'];
                
                if (!empty($_FILES['image_url']['name'])) {
                        $imageFileName = basename($_FILES['image_url']['name']);
                        $targetFilePath = "../public/" . $imageFileName;
                        
                        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $targetFilePath)) {
                                $newImage = $imageFileName;
                        } else {
                                $error = "Error uploading image.";
                        }
                } else {
                        $newImage = $product['image_url']; // Keep existing image
                }
		
                $newCat = $_POST['category_name'];
                $catQuery = "SELECT category_id FROM categories WHERE category_name='$newCat'";
                
		$categoryResult=mysqli_query($connection, $catQuery);
		if (!$categoryResult){
                        $error="Category check query failed.";
                }
                $newCategory=mysqli_fetch_assoc($categoryResult);
                if ($newCategory){
                        $newCatId=$newCategory['category_id'];
                } else {
                        $newCatId=$product['category_id'];
			$error="Category not found.";
               }
                
                $updateQuery = "UPDATE products SET name='$newName', description='$newDesc', price='$newPrice', category_id='$newCatId', image_url='$newImage', sku='$newSku' WHERE product_id=$productid";
                $updateResult = mysqli_query($connection, $updateQuery);
                if (!$updateResult){
                        $error="Update query failed.";
                }
                $error="Update successful!";
		// Refresh the page after
                echo "<meta http-equiv='refresh' content='1'>";
        }


	if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['selectedproduct'])) {
		$productid=$_POST['selectedproduct'];
		$query="SELECT * FROM products WHERE product_id=$productid";
		$result=mysqli_query($connection, $query);
		$product=mysqli_fetch_assoc($result);
		
		$category_id=$product['category_id'];
		$catquery="SELECT category_name FROM categories WHERE category_id=$category_id";
		$catresult=mysqli_query($connection, $catquery);
		if (!$catresult){
			$error="Category query failed.";
		}
		$category=mysqli_fetch_assoc($catresult);
	?>
	<form action="modifyproduct.php?id=<?php echo $productid; ?>" method="post" enctype="multipart/form-data" class="admin form">
                <div class="in-section">
                        <label class="in-label">Name</label>
                        <input class="in-input" type="text" name="name" value="<?php echo $product['name']; ?>">
                </div>
                <div class="in-section">
                        <label class="in-label">Description</label>
                        <textarea class="in-text" name="description" placeholder="<?php echo $product['description']; ?>"></textarea>
                </div>
                <div class="in-section">
                        <label class="in-label">Price</label>
                        <input class="in-input" type="number" step="0.01" min="0" name="price" value="<?php echo $product['price']; ?>">
                </div>
                <div class="in-section">
                        <label class="in-label">Category</label>
                        <input class="in-input" type="text" name="category_name" value="<?php echo $category['category_name']; ?>">
                </div>
                <div class="in-section">
                        <label class="in-label">Image</label>
                        <input class="in-input" type="file" name="image_url" accept="image/*">
			<img class="product-card-img" src="../public/<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="in-section">
                        <label class="in-label">SKU</label>
                        <input class="in-input" type="text" name="sku" value="<?php echo $product['sku']; ?>">
                </div>
                <input class="in-btn" type="submit" value="Modify Product">
                <?php if (!empty($error)) : ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
        </form>
	<?php 
	} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
                $productid = $_GET['id'];
                $query="SELECT * FROM products WHERE product_id=$productid";
                $result=mysqli_query($connection, $query);
                $product=mysqli_fetch_assoc($result);
                
                if (!$product){
                        $error="Error retrieving product.";
                }
                
                $newName = $_POST['name'] ?: $product['name'];
                $newDesc = $_POST['description'] ?: $product['description'];
                $newPrice = $_POST['price'] ?: $product['price'];
                $newSku = $_POST['sku'] ?: $product['sku'];
                
                if (!empty($_FILES['image_url']['name'])) {
                        $imageFileName = basename($_FILES['image_url']['name']);
                        $targetFilePath = "../public/" . $imageFileName;
                        
                        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $targetFilePath)) {
                                $newImage = $imageFileName;
                        } else {
                                $error = "Error uploading image.";
                        }
                } else {
                        $newImage = $product['image_url']; // Keep existing image
                }
                
                $newCat = $_POST['category_name'];
                $catQuery = "SELECT category_id FROM categories WHERE category_name='$newCat'";
                
                $categoryResult=mysqli_query($connection, $catQuery);
                if (!$categoryResult){
                        $error="Category check query failed.";
                }
                $newCategory=mysqli_fetch_assoc($categoryResult);
                if ($newCategory){
                        $newCatId=$newCategory['category_id'];
                } else {
                        $newCatId=$product['category_id'];
                        $error="Category not found.";
               }
                
                $updateQuery = "UPDATE products SET name='$newName', description='$newDesc', price='$newPrice', category_id='$newCatId', image_url='$newImage', sku='$newSku' WHERE product_id=$productid";
                $updateResult = mysqli_query($connection, $updateQuery);
                if (!$updateResult){
                        $error="Update query failed.";
                }
                $error="Update successful!";
		// Refresh the page after 
                echo "<meta http-equiv='refresh' content='1'>";
        } else {?>
	<div class="card">
        	<p>Error: Must select product to modify.</p>
        </div>
	<?php } ?>

</div>

<?php
include "../includes/footer.php";
?>
