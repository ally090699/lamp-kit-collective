<!-- Login page -->
<?php include "../includes/header.php"?>
<div>
    <?php include "../includes/connectdb.php";?>
</div>
<?php 
$error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $error="Error: Email, Username, and Password are required!";
    }

    $username=$_POST["username"];
    $password=$_POST["password"];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query='SELECT * FROM users WHERE username="'.$username.'"';

    $result=mysqli_query($connection,$query);
    if (!$result){
        $error="Database query login page failed.";
    }
    if ($user=mysqli_fetch_assoc($result)){
        if ($user["password_hash"]==$password){
            $error="Login Success!";
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["email"] = $user["email"];

            header("Location: /lamp-kit-collective/public/profile.php");
            exit();
        } else {
            $error="Invalid password.";
        }
    } else {
        $error="Invalid username.";
    }
}
?>
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
    <p class='error-statement'><?php if ($error) {echo htmlspecialchars($error);} ?></p>
</form>

 <?php include "../includes/footer.php"?>
