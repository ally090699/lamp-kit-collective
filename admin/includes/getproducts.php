<?php
$query="SELECT * FROM products";
$result=mysqli_query($connection, $query);
if (!$result){
	die("Get products query failed.");
}
?>
