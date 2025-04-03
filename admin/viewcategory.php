<?php 
include "../includes/header.php";
include "../includes/connectdb.php";
include "includes/getcategories.php";
?>

<div class="flexcol main">
        <h1 class="title">View Categories</h1>
        <ul>
        <?php 
        while ($category=mysqli_fetch_assoc($result)){
        ?>
                <li><h4><?php echo $category['category_name']; ?></h4></li>
        <?php } ?>
	</ul>
</div>

<?php
include "../includes/footer.php";
?>
