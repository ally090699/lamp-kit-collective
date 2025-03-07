<!-- Home page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit Collective</title>
    <link rel="stylesheet" href="/lamp-kit-collective/public/assets/styles.css">
</head>
<body>
    <h1>Kit Collective</h1>
    <h3>Welcome to the Kit Collective Product Management System!</h3>
    <?php include "../includes/connectdb.php";?>
    <hr/>
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
</body>
</html>