<?php
include "../includes/header.php";
include "../includes/connectdb.php";

$error="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_FILES["image_url"]['name']) || empty($_POST['sku'])){
                $error="Missing product details.";
        }
        $name=$_POST['name'];
	$description=$_POST['description'];
	$price=$_POST['price'];
	
	if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === 0) {
		$image_url=$_FILES["image_url"]['name'];
		$target_dir="../uploads/";
		$target_file=$target_dir.basename($image_url);
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        	$allowed_types = ["jpg", "jpeg", "png", "webp"];

		if (!in_array($imageFileType, $allowed_types)){
			$error="Only JPG, JPEG, PNG, and WEBP files are allowed.";
		} elseif ($_FILES["image_url"]["size"] > 2 * 1024 * 1024) {
			$error="File size too large. Maximum allowed size is 2MB.";
		} elseif (move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file)){
			$image_url=$target_file;
		} else {
			$error="Error uploading image.";
		}
	} else {
		$error="No file uploaded or error in uploading.";
	}
	
	if (empty($error)){
		$category_id=$_POST['category_id'] ?? null;
		$sku=$_POST['sku'];
        	
        	$query="SELECT sku FROM products WHERE sku='$sku'";
        	$result=mysqli_query($connection, $query);
        	if (!$result){
        	        $error="Database error.";
        	} elseif (mysqli_num_rows($result)>0){
        	        $error="SKU already exists.";
        	} else {
        	        $query="INSERT INTO products (name, description, price, category_id, image_url, sku) VALUES ('$name', '$description', '$price', '$category_id', '$image_url', '$sku')";
        	        $result=mysqli_query($connection, $query);
        	        if (!$result){
        	                $error="Error adding product, please try again.";
        	        }
        	        $error="Successfully added product!";
        	}
	}
}

?>

<div class="flexcol main center">
        <h1 class="title">Add Product</h1>
        <form action="addproduct.php" method="post" enctype="multipart/form-data" class="admin form">
                <div class="in-section">
                        <label class="in-label">Name</label>
                        <input class="in-input" type="text" name="name" placeholder="Enter product name" required>
                </div>
		<div class="in-section">
                        <label class="in-label">Description</label>
                        <textarea class="in-text" name="description" placeholder="Enter description here" required></textarea>
                </div>
		<div class="in-section">
                        <label class="in-label">Price</label>
                        <input class="in-input" type="number" step="0.01" min="0" name="price" placeholder="10.99" required>
                </div>
		<div class="in-section">
                        <label class="in-label">Category</label>
			<select name="category_id">
				<option>Select category here</option>
				<?php 	include "includes/getcategories.php";
					while ($category=mysqli_fetch_assoc($result)){
        	        	?>
					<option value="<?php echo $category['category_id']; ?>">
						<?php echo $category['category_name']; ?>
					</option>
				<?php	} ?>
			</select>
		</div>
		<div class="in-section">
                        <label class="in-label">Image</label>
                        <input class="in-input" type="file" name="image_url" accept="image/*">
                </div>
		<div class="in-section">
                        <label class="in-label">SKU</label>
                        <input class="in-input" type="text" name="sku" placeholder="Enter product sku">
                </div>
		<input class="in-btn" type="submit" value="Add Product">
                <?php if (!empty($error)) : ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
        </form> 
</div>

<?php
include "../includes/footer.php";
?>
