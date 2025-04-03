<?php
$query="SELECT * FROM orders";
$result=mysqli_query($connection, $query);
if (!$result){
        die("Get orders query failed.");
} 
?>
