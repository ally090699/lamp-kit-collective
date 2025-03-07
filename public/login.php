<!-- Login page -->
<?php include "../includes/header.php"?>
<div>
    <?php include "../includes/connectdb.php";?>
</div>
<h2 class="title">Welcome Back!</h2>
<form action="index.php" method="post" class="login-form">
    <div class="login-section">
        <h5 class="login-label">Username</h5>
        <input class="login-input" type="text" name="username" placeholder="Enter username here"/>
    </div>
    <div class="login-section">
        <h5 class="login-label">Password</h5>
        <input class="login-input" type="password" name="password" placeholder="Enter password here"/>
    </div>
    <div class="login-section">
        <p>Don't have an account? <a href="/lamp-kit-collective/public/register.php">Create</a> one now!</p>
    </div>
</form>
 <?php include "../includes/footer.php"?>
