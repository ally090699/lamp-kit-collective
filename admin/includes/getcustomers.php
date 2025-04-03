<?php
$query="SELECT * FROM users WHERE is_admin=0";
$result=mysqli_query($connection, $query);
if (!$result){
        die("Get customers query failed.");
} 
?>
