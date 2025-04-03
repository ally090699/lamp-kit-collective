<?php
include "../includes/header.php";
include "../includes/connectdb.php";

$error="";
?>
<div class="flexcol main">
        <h1 class="title">Modify Category</h1>
        <form action="modifycategory.php" method="post" class="in-form">
                <select name="category_id">
			<option>Select category here</option>
			<?php
			include "includes/getcategories.php";
			while ($category = mysqli_fetch_assoc($result)){
			?>
				<option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                	<?php } ?>
		</select>
		<input class="in-btn" type="submit" value="Select Category">
                <?php if (!empty($error)) : ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
        </form> 
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id'])) {
        $category_id=$_POST['category_id'];
        
        $query="SELECT category_name FROM categories WHERE category_id='$category_id'";
        $result=mysqli_query($connection, $query);
        if (!$result){
                $error="Database error.";
        } else {
	$category=mysqli_fetch_assoc($result);
?>
	<form action="modifycategory.php" method="post" class="in-form">
		<div class="in-section">
			<label class="in-label">New Category Name</label>
			<input class="in-input" type="text" name="category_name" placeholder="<?php echo $category['category_name']; ?>">
			<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
			<input class="in-btn" type="submit" value="Modify Category">
			<?php if (!empty($error)) : ?>
                	        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                	<?php endif; ?>
		</div>
	</form>
<?php
        }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
	$newCat = $_POST['category_name'];
	$query="UPDATE categories SET category_name='$newCat' WHERE category_id='$category_id'";
	$result=mysqli_query($connection, $query);
	if (!$result){
		$error="Set category query failed.";
	} else {
		$error="Category successfully updated!";
		echo "<meta http-equiv='refresh' content='1'>";
	}
}

?>

</div>

<?php
include "../includes/footer.php";
?>
