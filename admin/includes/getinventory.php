<?php
$query="SELECT * FROM inventory";
$result=mysqli_query($connection, $query);
if (!$result){
        die("Get inventory query failed.");
} 
?>
