<!-- Shop page -->
<?php include "../includes/header.php"?>
<div class="product-main">
    <h1 class="title">Browse Our Shop!</h1>
    <?php include "../includes/connectdb.php";?>
</div>
<div class='product-grid'>
<?php 
    $query = "SELECT * FROM products";
    $result = mysqli_query($connection, $query);
    if (!$result){
        echo "<h6>Products failed to load. Please try again.</h6>";
        die("Databases query failed");
    }
    while ($row = mysqli_fetch_assoc($result)){
        echo "<div class='product-card'>
                <img class='product-card-img'
                src='".$row['image_url']."'
                alt='Crochet ".$row['name']."'
                />
                <div>
                <h5 class='product-card-name'>".$row['name']."</h5>
                <h5 class='product-card-price'>".$row['price']."</h5>
                </div>
                <div class='product-card-btndiv'>
                    <button class='product-card-btn'>Add to Cart</button>
                </div>
            </div>";
    }
    mysqli_free_result($result);
?>
</div>
 <?php include "../includes/footer.php"?>
