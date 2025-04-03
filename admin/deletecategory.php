<?php
include "../includes/header.php";
include "../includes/connectdb.php";
$error = "";
?>

<div class="flexcol main">
    <h1 class="title">Delete Category</h1>
    <form action="deletecategory.php" method="post">
        <select name="selectedcategory">
            <option value="">Select category here</option>
            <?php 
            include "includes/getcategories.php";
            while ($category = mysqli_fetch_assoc($result)) {
            ?>
                <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
            <?php } ?>
        </select>
        <input class="in-btn" type="submit" value="Delete Category">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['selectedcategory'])) {
            echo '<div class="card"><p class="error">Error: Must select a category to delete.</p></div>';
        } else {
            $category_id = $_POST['selectedcategory'];
            
            $checkProductQuery = "SELECT COUNT(*) AS product_count FROM products WHERE category_id = $category_id";
            $checkProductResult = mysqli_query($connection, $checkProductQuery);
            $checkData = mysqli_fetch_assoc($checkProductResult);
            
            if ($checkData['product_count'] > 0) {
                echo '<div class="card"><p class="error">Error: This category cannot be deleted because there are existing products under this category.</p></div>';
            } else {
                $query = "DELETE FROM categories WHERE category_id=$category_id";
                $result = mysqli_query($connection, $query);

                if (!$result) {
                    echo '<div class="card"><p class="error">Error deleting category.</p></div>';
                } else {
                    echo '<div class="card"><p class="success">Category successfully deleted!</p></div>';
                    // Refresh the page after deletion to update product list
                    echo "<meta http-equiv='refresh' content='1'>";
                }
            }
        }
    }
    ?>
</div>

<?php include "../includes/footer.php"; ?>
