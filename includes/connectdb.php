<?php
$dbConfig = require_once __DIR__ . '/../config/database.php';

$connection = mysqli_connect(
    $dbConfig['host'], 
    $dbConfig['username'], 
    $dbConfig['password'], 
    $dbConfig['database'], 
    $dbConfig['port']);

if (mysqli_connect_errno()){
    echo "<h5>Database connection failed!</h5>";
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
} else {
    echo "<h5>Database connection successful!</h5>";
}
?>