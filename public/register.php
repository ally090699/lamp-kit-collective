<!-- Register page -->
<?php include "../includes/header.php"?>
<div>
    <?php include "../includes/connectdb.php";?>
</div>
<h2 class="title">Create an Account</h2>
<form action="index.php" method="post" class="login-form">
    <div class="login-section">
        <h5 class="login-label">First Name</h5>
        <input class="login-input" type="text" name="firstname" placeholder="Enter first name (Optional)"/>
    </div>
    <div class="login-section">
        <h5 class="login-label">Last Name</h5>
        <input class="login-input" type="text" name="lastname" placeholder="Enter last name (Optional)"/>
    </div>
    <div class="login-section">
        <h5 class="login-label">Email</h5>
        <input class="login-input" type="text" name="email" placeholder="Enter email" required/>
    </div>
    <div class="login-section">
        <h5 class="login-label">Phone Number</h5>
        <input class="login-input" type="text" name="phonenumber" placeholder="Enter phone number (Optional)"/>
    </div>
    <div class="login-section">
        <h5 class="login-label">Username</h5>
        <input class="login-input" type="text" name="username" placeholder="Enter username" required/>
    </div>
    <div class="login-section">
        <h5 class="login-label">Password</h5>
        <input class="login-input" type="password" name="password" placeholder="Enter password" required/>
    </div>
    <div class="login-section">
        <p>Already have an account? <a href="/lamp-kit-collective/public/login.php">Login</a> now!</p>
    </div>
</form>
 <?php include "../includes/footer.php"?>