<?php 
session_start(); 

if (isset($_SESSION['user_id'])) {
    session_unset();
    session_destroy();
    header("Location: /lamp-kit-collective/public/login.php");
    exit;
}
?>