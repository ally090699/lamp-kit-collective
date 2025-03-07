<?php
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$port = $_ENV['DB_PORT'];

$connection = mysqli_connect($host, $dbname, $user, $pass, $port);

if (mysqli_connect_errno()){
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}
?>