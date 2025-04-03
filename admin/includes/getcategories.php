<?php
$query="SELECT * FROM categories";
$result=mysqli_query($connection, $query);
if (!$result){
        die("Get categories query failed.");
} 
?>
