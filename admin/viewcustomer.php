<?php 
include "../includes/header.php";
include "../includes/connectdb.php";
?>

<div class="flexcol main">
        <h1 class="title">View Customers</h1>
        <form action="viewcustomer.php" method="post">
                <input class="in-input" type="text" name="search" placeholder="Search name, email, phone number..."/>
                <input class="in-btn" type="submit" value="Search">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (empty($_POST['search'])){
			$query="SELECT * FROM users WHERE is_admin=0";
			$result=mysqli_query($connection,$query);
			if (!$result){
				die("General user query failed.");
			}
			while ($customer=mysqli_fetch_assoc($result)){
	?>
		<div class="card">
                        <h4><b>Name: </b><?php echo $customer['first_name']." ".$customer['last_name']; ?></h4>
                        <p><b>Username:</b> <?php echo $customer['username']; ?></p>
                        <p><b>Email:</b> <?php echo $customer['email']; ?></p>
                        <p><b>Phone Number:</b> <?php echo $customer['phone_number']; ?></p>
                        <p><b>Created:</b> <?php echo $customer['created_at']; ?></p>
                        <p><b>Last Updated:</b> <?php echo $customer['updated_at']; ?></p>
                </div>
	<?php
			}
       		} else {
			$search = $_POST['search'];
                	$query="SELECT * FROM users WHERE (CONCAT_WS(' ', first_name, last_name) LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%') AND is_admin=0";
                	$result=mysqli_query($connection,$query);
			if (mysqli_num_rows($result) > 0) {
                		while($customer=mysqli_fetch_assoc($result)){
        ?>
                <div class="card">
                        <h4><b>Name: </b><?php echo $customer['first_name']." ".$customer['last_name']; ?></h4>
                        <p><b>Username:</b> <?php echo $customer['username']; ?></p>
                        <p><b>Email:</b> <?php echo $customer['email']; ?></p>
                        <p><b>Phone Number:</b> <?php echo $customer['phone_number']; ?></p>
                        <p><b>Created:</b> <?php echo $customer['created_at']; ?></p>
                        <p><b>Last Updated:</b> <?php echo $customer['updated_at']; ?></p>
                </div>
        <?php 
				}
			} else {
	?>
		<div class="card">
			<p>No customers matching your search.</p>
		</div>
	<?php
			}
		}
	}
	?>
        </div>
</div>


<?php
include "../includes/footer.php";
?>
