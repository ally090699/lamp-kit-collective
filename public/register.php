<!-- Register page -->
<?php include "../includes/header.php"?>
<div>
    <?php include "../includes/connectdb.php";?>
</div>
<h2 class="title">Create an Account</h2>
<form action="register.php" method="post" class="in-form">
    <div class="in-section">
        <h5 class="in-label">First Name</h5>
        <input class="in-input" type="text" name="firstname" placeholder="Enter first name (Optional)"/>
    </div>
    <div class="in-section">
        <h5 class="in-label">Last Name</h5>
        <input class="in-input" type="text" name="lastname" placeholder="Enter last name (Optional)"/>
    </div>
    <div class="in-section">
        <h5 class="in-label">Email</h5>
        <input class="in-input" type="text" name="email" placeholder="Enter email" required/>
    </div>
    <div class="in-section">
        <h5 class="in-label">Phone Number</h5>
        <input class="in-input" type="text" name="phonenumber" placeholder="Enter phone number (Optional)"/>
    </div>
    <div class="in-section">
        <h5 class="in-label">Username</h5>
        <input class="in-input" type="text" name="username" placeholder="Enter username" required/>
    </div>
    <div class="in-section">
        <h5 class="in-label">Password</h5>
        <input class="in-input" type="password" name="password" placeholder="Enter password" required/>
    </div>
    <div class="in-section">
        <p>Already have an account? <a href="/lamp-kit-collective/public/login.php">Login</a> now!</p>
    </div>
    <input class="in-btn" type="submit" value="Register">
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"])) {
        echo "<p>Error: Email, Username, and Password are required!</p>";
        exit;
    }

    $firstname=$_POST["firstname"] ?? "";
    $lastname=$_POST["lastname"] ?? "";
    $email=$_POST["email"];
    $phonenumber=$_POST["phonenumber"] ?? "";
    $username=$_POST["username"];
    $password=$_POST["password"];
    $error="";

    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $email = mysqli_real_escape_string($connection, $email);
    $phonenumber = mysqli_real_escape_string($connection, $phonenumber);
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $checkQuery="SELECT username FROM users WHERE username = '$username'";
    $checkResult = mysqli_query($connection, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<p>Error: Username already exists!</p>";
        exit;
    }

    $registerQuery="INSERT INTO users (username, email, password_hash, first_name, last_name, phone_number) VALUES('$username', '$email', '$password', '$firstname', '$lastname', '$phonenumber')";

    $result=mysqli_query($connection,$registerQuery);
    if (!$result){
        echo "<p>Registration failed</p>";
        die("Registration failed.");
    } else {
        echo "<p>Registration successful!</p>";
    }
}
?>
</form>
 <?php include "../includes/footer.php"?>