<?php 
include "../includes/header.php";
include "../includes/connectdb.php";
?>

<div class="flexcol main">
        <h1 class="title">View Order</h1>
        <form action="vieworder.php" method="post">
                <select name="selectedorder">
                        <option>Select order here</option>
                <?php 
                include "includes/getorders.php";
                while ($order=mysqli_fetch_assoc($result)){
                ?>
                        <option value="<?php echo $order['order_id']; ?>">Order #<?php echo $order['order_id']; ?></option>
                <?php } ?>
                </select>
                <input class="in-btn" type="submit" value="Select order">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST['selectedorder'])){
        ?>
                <p>No order selected.</p>
        <?php   }
                $orderid=$_POST['selectedorder'];
                $query="SELECT * FROM orders WHERE order_id=$orderid";
                $result=mysqli_query($connection, $query);
                if (!$result){
                        die("View selected order query failed.");
                }
                $order=mysqli_fetch_assoc($result);

                $userid=$order['user_id'];
                $query="SELECT * FROM users WHERE user_id=$userid";
                $result=mysqli_query($connection, $query);
                if (!$result){
                        die("User query failed.");
                }
                $user=mysqli_fetch_assoc($result);
        ?>
                <div class="card">
                        <h4><b>Order #<?php echo $order['order_id']; ?></b></h4>
                        <p><b>Customer:</b> <?php echo $user['first_name']." ".$user['last_name']; ?></p>
                        <p><b>Total:</b> $<?php echo number_format($order['total_price'], 2); ?></p>
                        <p><b>Status:</b> <?php echo $order['order_status']; ?></p>
                        <p><b>Payment Method:</b> <?php echo ucfirst(str_replace('_', ' ', $order['payment_method'])); ?></p>
                        <p><b>Created:</b> <?php echo date("F j, Y, g:i A", strtotime($order['created_at'])); ?></p>
                </div>
        <?php } ?>
        </div>
</div>


<?php
include "../includes/footer.php";
?>
