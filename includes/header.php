<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit Collective</title>
    <link rel="stylesheet" href="/lamp-kit-collective/public/assets/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Dosis:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="./assets/favicon.ico" type="image/x-icon">
    <script src="/assets/scripts.js" defer></script>
</head>
<body>
<nav>
    <div id='navbar'>
        <!-- Brand -->
        <img
            src="./public/assets/images/banner.jpg"
            alt="Kit Collective Logo"
            class="header-logo"
        />
        <!-- Menu -->
        <div class="menu">
            <a href="/lamp-kit-collective/public/index.php">Home</a>
            <a href="/lamp-kit-collective/public/shop.php">Shop</a>

            <!-- Customers (logged in) -->
            <?php if (isset($_SESSION['username'])): ?>
                <a href="/lamp-kit-collective/public/cart.php">Cart 🛒</a>
                <a href="/lamp-kit-collective/public/profile.php">Profile</a>
                <a href="/lamp-kit-collective/public/logout.php">Logout</a>
            <!-- Customers (not logged in) -->
            <?php else: ?>
                <a href="/lamp-kit-collective/public/login.php">Login</a>
                <a href="/lamp-kit-collective/public/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>