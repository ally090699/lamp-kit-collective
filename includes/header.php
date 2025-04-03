<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit Collective</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Dosis:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" href="../public/assets/favicon.ico" type="image/x-icon">
    <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin']==1): ?>
			<link rel="stylesheet" href="../public/assets/styles.css">
        		<script src="../public/assets/scripts.js" defer></script>
			<link rel="stylesheet" href="../admin/assets/styles.css">
 	 	        <script src="../admin/assets/scripts.js" defer></script>

		<?php elseif ($_SESSION['is_admin']==0): ?>
			<link rel="stylesheet" href="../public/assets/styles.css">
		        <script src="../public/assets/scripts.js" defer></script>
		<?php endif; ?>
    <?php else: ?>
	<link rel="stylesheet" href="../public/assets/styles.css">
        <script src="../public/assets/scripts.js" defer></script>
    <?php endif; ?>
</head>
<body>
<nav>
    <div id='navbar'>
        <!-- Brand -->
        <img
            src="../public/assets/images/banner.webp"
            alt="Kit Collective Logo"
            class="header-logo"
        />
        <!-- Menu -->
        <div class="menu">            
	    <?php if (isset($_SESSION['user_id'])): ?>
		<?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin']==1): ?>
			<a href="../admin/dashboard.php">Dashboard</a>
                	<div class="toggle">
				<a href="#">Management</a>
				<div class="dropdown">	
					<a href="../admin/manage_products.php">Products</a>
                			<a href="../admin/manage_categories.php">Categories</a>
                			<a href="../admin/manage_inventory.php">Inventory</a>
					<a href="../admin/manage_orders.php">Orders</a>
					<a href="../admin/manage_users.php">Customers</a>
					<a href="../admin/manage_content.php">Content</a>
				</div>
			</div>
			<a href="../admin/logout.php">Logout</a>
		<?php elseif ($_SESSION['is_admin']==0): ?>
                	<a href="../public/index.php">Home</a>
			<a href="../public/shop.php">Shop</a>
                	<a href="../public/cart.php">Cart 🛒</a>
                	<a href="../public/profile.php">Profile</a>
                	<a href="../public/logout.php">Logout</a>
		<?php endif; ?>
            <!-- Customers (not logged in) -->
	    <?php else: ?>
		<a href="../public/index.php">Home</a>
		<a href="../public/shop.php">Shop</a>
                <a href="../public/login.php">Login</a>
                <a href="../public/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
