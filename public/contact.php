<!-- Contact page -->
<?php include "../includes/header.php"; ?>
<?php 
    include "../includes/connectdb.php";
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"]) || empty($_POST["reason"]) || empty($_POST["message"])) {
            $error="Error: Required fields are missing!";
        }

        $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
        $name = mysqli_real_escape_string($connection, $_POST["name"]);
        $phone = isset($_POST["phonenumber"]) ? mysqli_real_escape_string($connection, $_POST["phonenumber"]) : null;
        $email = mysqli_real_escape_string($connection, $_POST["email"]);
        $reason = mysqli_real_escape_string($connection, $_POST["reason"]);
        $message = mysqli_real_escape_string($connection, $_POST["message"]);

        $sku = null;

        switch ($reason) {
            case "General Inquiry":
                $reason = "General_Inquiry";
                break;
            case "Pricing":
                $reason = "Pricing";
                break;
            case "Product Info":
                $reason = "Product_Info";
                $sku = isset($_POST["productid"]) ? mysqli_real_escape_string($connection, $_POST["productid"]) : null;
                break;
            case "Shipping":
                $reason = "Shipping";
                break;
            case "Other":
                $reason = "Other";
                break;
        }

        $query = "INSERT INTO form_submissions (user_id, name, phone, email, reason, message, sku)
          VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "issssss", $user_id, $name, $phone, $email, $reason, $message, $sku);

        if (mysqli_stmt_execute($stmt)) {
            $error = "Contact form submitted successfully!";
        } else {
            $error = "Contact form submission failed.";
        }

        mysqli_stmt_close($stmt);
    }
?>

<div class="contact-page">
    <h4 class="title">📞 Contact Us</h4>
    <form action="contact.php" method="post" id="contact-form">

        <?php if ($error) { echo "<p class='error-msg'>" . htmlspecialchars($error) . "</p>"; } ?>

        <div class="in-section">
            <h5 class="in-label">Name</h5>
            <input class="in-input" id="name" type="text" name="name" onblur="checkFirstname(this.value)" placeholder="Jane Doe" required/>
        </div>
        <div class="in-section">
            <h5 class="in-label">Phone Number</h5>
            <input class="in-input" id="phonenumber" type="text" name="phonenumber" onblur="checkPhone(this.value)" placeholder="888 888 8888"/>
        </div>
        <div class="in-section">
            <h5 class="in-label">Email</h5>
            <input class="in-input" id="emailinput" type="text" name="email" onblur="checkEmail(this.value)" placeholder="janedoe123@gmail.com" required/>
        </div>

        <div class="in-section">
            <h5 class="in-label">Reason for Message</h5>
            <div class="radio-group">
                <label><input type="radio" name="reason" value="General Inquiry" onchange="updateStatus()"> General Inquiry</label>
                <label><input type="radio" name="reason" value="Pricing" onchange="updateStatus()"> Pricing</label>
                <label><input type="radio" name="reason" value="Product Info" onchange="updateStatus()"> Product Info</label>
                <label><input type="radio" name="reason" value="Shipping" onchange="updateStatus()"> Shipping</label>
                <label><input type="radio" name="reason" value="Other" onchange="updateStatus()"> Other</label>
            </div>
        </div>

        <?php
            $skus = [];
            $query = "SELECT DISTINCT sku FROM products";
            $result = mysqli_query($connection, $query);
            if (!$result || mysqli_num_rows($result) == 0) {
                die("Product SKUs not found.");
            }
            while ($product = mysqli_fetch_assoc($result)) {
                $skus[] = $product['sku'];
            }
        ?>
        
        <div class="in-section pid hidden">
            <h5 class="in-label" id="productid">Product ID</h5>
            <input type="text" id="productnum" name="productid" class="textbox in-input" placeholder="ABC-DEF-123" onblur="checkProductID(this.value);" />
        </div>

        <div class="in-section">
            <h5 class="in-label">Message</h5>
            <textarea class="in-input" id="message" name="message" onblur="checkMessage(this.value)" placeholder="Enter message here" required></textarea>
        </div>

        <input class="in-btn" type="submit" value="Submit Message">
    </form>
</div>

<script>
    const skus = <?php echo json_encode($skus); ?>;

    function checkProductID(value) {
        let productIDBox = document.getElementById("productnum");
        let success = skus.includes(value);
        productIDBox.style.borderColor = success ? "" : "red";
    }
</script>

<?php include "../includes/footer.php"; ?>
