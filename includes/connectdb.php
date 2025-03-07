<?php
$dbConfig = require_once __DIR__ . '/../config/database.php';

$connection = mysqli_connect(
    $dbConfig['host'], 
    $dbConfig['username'], 
    $dbConfig['password'], 
    $dbConfig['database'], 
    $dbConfig['port']);

if (mysqli_connect_errno()){
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}
?>