<!-- Login page -->
<?php include "../includes/header.php"?>
<div>
    <?php include "../includes/connectdb.php";?>
</div>
<h2 class="title">Welcome Back!</h2>
<form action="login.php" method="post" class="in-form">
    <div class="in-section">
        <h5 class="in-label">Username</h5>
        <input class="in-input" type="text" name="username" placeholder="Enter username here"/>
    </div>
    <div class="in-section">
        <h5 class="in-label">Password</h5>
        <input class="in-input" type="password" name="password" placeholder="Enter password here"/>
    </div>
    <div class="in-section">
        <p>Don't have an account? <a href="/lamp-kit-collective/public/register.php">Create</a> one now!</p>
    </div>
    <input class="in-btn" type="submit" value="Login">
</form>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        echo "<p>Error: Email, Username, and Password are required!</p>";
        exit;
    }

    $username=$_POST["username"];
    $password=$_POST["password"];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query='SELECT * FROM users WHERE username="'.$username.'"';

    $result=mysqli_query($connection,$query);
    if (!$result){
        die("Database query login page failed.");
    }
    if ($user=mysqli_fetch_assoc($result)){
        if ($user["password_hash"]==$password){
            echo "<p>Login Success!</p>";
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];

            header("Location: /lamp-kit-collective/public/profile.php");
            exit();
        } else {
            echo "<p>Invalid password.</p>";
        }
    } else {
        echo "<p>Invalid username.</p>";
    }
}
?>
 <?php include "../includes/footer.php"?>
