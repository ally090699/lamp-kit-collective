<?php
include "../includes/header.php";
include "../includes/connectdb.php";

$error="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['category_name'])){
		$error="No category name provided.";
	}
	$category_name=$_POST['category_name'];
	
	$query="SELECT category_name FROM categories WHERE category_name='$category_name'";
	$result=mysqli_query($connection, $query);
	if (!$result){
		$error="Database error.";
	} elseif (mysqli_num_rows($result)>0){
		$error="Category name already exists.";
	} else {
		$query="INSERT INTO categories (category_name) VALUES ('$category_name')";
		$result=mysqli_query($connection, $query);
		if (!$result){
			$error="Error adding category, please try again.";
		}
		$error="Successfully added category!";
	}
}

?>

<div class="flexcol main">
        <h1 class="title">Add Category</h1>
        <form action="addcategory.php" method="post" class="in-form">
                <div class="in-section">
			<label class="in-label">Category Name</label>
			<input class="in-input" type="text" name="category_name" placeholder="Category Name">
                </div>
		<input class="in-btn" type="submit" value="Add Category">
		<?php if (!empty($error)) : ?>
			<p class="error"><?php echo htmlspecialchars($error); ?></p>
		<?php endif; ?>
        </form>	
</div>

<?php
include "../includes/footer.php";
?>
