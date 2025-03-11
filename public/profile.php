<!-- Profile page -->
<?php include "../includes/header.php"?>
<?php 
    include "../includes/connectdb.php";
?>
<?php 
    if (!isset($_SESSION["user_id"])) {
        header("Location: /lamp-kit-collective/public/login.php");
        exit;
    }
    $_SESSION["error"] = "";
    $_SESSION["success"] = "";

    $user_id=$_SESSION["user_id"];
    $username=$_SESSION["username"];
    $user_email=$_SESSION["email"];
    $display=false;

    $username = mysqli_real_escape_string($connection, $username);

    $query="SELECT * FROM users WHERE username='$username'";

    $result=mysqli_query($connection,$query);
    if (!$result){
        $_SESSION["error"] = "Profile query failed.";
    }

    $user=mysqli_fetch_assoc($result);
    if (!$user){
        $_SESSION["error"] = "User not found.";
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION["error"] = "";
        $_SESSION["success"] = "";
        $display=true;
        $first_name = $_POST["firstname"] ?? "";
        $last_name = $_POST["lastname"] ?? "";
        $phone_number = $_POST["phonenumber"] ?? "";
        $password = $_POST["password"] ?? "";
        $confirm_password = $_POST["confirmpassword"] ?? "";

        $first_name = mysqli_real_escape_string($connection, trim($first_name));
        $last_name = mysqli_real_escape_string($connection, trim($last_name));
        $phone_number = mysqli_real_escape_string($connection, trim($phone_number));

        if ($first_name == $user["first_name"] &&
            $last_name == $user["last_name"] &&
            $phone_number == $user["phone_number"] &&
            empty($password)) {
            $_SESSION["error"] = "No changes have been made!";
        } else{
            $update_query = [];

            if (!empty($first_name) && $first_name !== $user["first_name"]) {
                $update_query[] = "first_name='$first_name'";
            }

            if (!empty($last_name) && $last_name !== $user["last_name"]) {
                $update_query[] = "last_name='$last_name'";
            }

            if (!empty($phone_number) && $phone_number !== $user["phone_number"]) {
                $update_query[] = "phone_number='$phone_number'";
            }

            if (!empty($password)) {
                if ($password !== $confirm_password) {
                    $_SESSION["error"] = "Passwords do not match!";
                } else {
                    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $update_query[] = "password_hash='$password'";
                }
            } 
            
            if (!empty($update_query)) {
                $query = "UPDATE users SET " . implode(", ", $update_query) . " WHERE username='$username'";
                if (mysqli_query($connection, $query)) {
                    $_SESSION["success"] = "Profile updated successfully!";
                    $display = false;
                    header("Location: profile.php");
                    exit;
                } else {
                    $_SESSION["error"] = "Failed to update profile.";
                }
            }
        }
    }

    $orderquery="SELECT * FROM orders WHERE user_id=$user_id";

    $orderresult=mysqli_query($connection,$orderquery);
    if (!$orderresult){
        $_SESSION["error"] = "Failed query (Profile, orders).";
    }
?>
<h1 class='title'><?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?>'s Profile</h1>

<div class='profile-section'>
    <div>
        <h5 class='profile-content'>First Name: <?php echo htmlspecialchars($user['first_name']);?></h5>
        <h5 class='profile-content'>Last Name: <?php echo htmlspecialchars($user['last_name']);?></h5>
        <h5 class='profile-content'>Username: <?php echo htmlspecialchars($user['username']);?></h5>
        <h5 class='profile-content'>Email: <?php echo htmlspecialchars($user['email']);?></h5>
        <h5 class='profile-content'>Phone Number: <?php echo htmlspecialchars($user['phone_number']);?></h5>
    </div>
    <button class='profile-edit-btn' onclick='toggleEditProfile()'>Edit Profile</button>
</div>

<form action='profile.php' method='post' id='edit-profile-form' style='display: <?php echo $display ? "flex" : "none"; ?>'>
    
    <?php 
        echo $_SESSION["error"];
        if (isset($_SESSION["error"])) {
            echo "<p class='error'>{$_SESSION["error"]}</p>";
            unset($_SESSION["error"]);
        }
        if (isset($_SESSION["success"])) {
            echo "<p class='success'>{$_SESSION["success"]}</p>";
            unset($_SESSION["success"]);
        }
    ?>

    <div class='in-section'>
        <h5 class='in-label'>First Name</h5>
        <input class='in-input' id='firstname' type='text' name='firstname' onblur='checkFirstname(this.value)' placeholder='<?php echo htmlspecialchars($user['first_name']); ?>'/>
    </div>
    <div class='in-section'>
        <h5 class='in-label'>Last Name</h5>
        <input class='in-input' id='lastname' type='text' name='lastname' onblur='checkLastname(this.value)' placeholder='<?php echo htmlspecialchars($user['last_name']); ?>'/>
    </div>
    <div class='in-section'>
        <h5 class='in-label'>Phone Number</h5>
        <input class='in-input' id='phonenumber' type='text' name='phonenumber' onblur='checkPhone(this.value)' placeholder='<?php echo htmlspecialchars($user['phone_number']);?>'/>
    </div>
    <div class='in-section'>
        <h5 class='in-label'>Password</h5>
        <input class='in-input' id='passwordinput' type='password' name='password' onblur='checkPassword(this.value)' placeholder='Enter password here'/>
    </div>
    <div class='in-section'>
        <h5 class='in-label'>Confirm Password</h5>
        <input class='in-input' id='confirmpasswordinput' type='password' name='confirmpassword' onblur='checkConfirmPassword(this.value, document.querySelector(\"input[name='password']\").value)' placeholder='Enter password here'/>
    </div>
    <input class='in-btn' type='submit' value='Update Profile'>
</form>

<div class="prev-order">
    <h3 class="header" >Previous Orders</h3>
    <?php while ($order = mysqli_fetch_assoc($orderresult)){ ?>
        <div class="order-container" onclick="window.location.href='order.php?id=<?php echo $order['order_id']; ?>'">
            <div class="order-sectleft">
                <h5 class="order-header">Order ID: #<?php echo htmlspecialchars($order['order_id']);?></h5>
                <h5 class="order-header">Payment Method: <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $order['payment_method'])));;?></h5>
                <h5 class="order-header">Created: <?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($order['created_at'])));?></h5>
            </div>
            
            <div class="order-sectright">
                <h5 class="order-header">Total: $<?php echo htmlspecialchars(number_format($order['total_price'], 2)); ?></h5>
                <h5 class="order-header">Status: <?php echo htmlspecialchars(ucfirst($order['order_status']));?></h5>
            </div>
        </div>
    <?php } ?>
</div>
 <?php include "../includes/footer.php"?>