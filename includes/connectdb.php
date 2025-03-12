<?php
// $dbConfig = require_once __DIR__ . '/../config/database.php';

$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');
$port=getenv('DB_PORT');

$connection = mysqli_connect($servername, $username, $password, $dbname, $port);
    // $dbConfig['host'],
    // $dbConfig['username'],
    // $dbConfig['password'],
    // $dbConfig['database'],
    // $dbConfig['port']);



if (mysqli_connect_errno()){
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}
?>