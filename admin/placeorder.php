<?php
include "../includes/header.php";
include "../includes/connectdb.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['user_id']) || empty($_POST['products']) || empty($_POST['payment_method']) || empty($_POST['quantity'])) {
        $error = "Missing order details.";
    } else {
        $user_id = $_POST['user_id'];
        $payment_method = $_POST['payment_method'];
        $products = $_POST['products'];
        $quantities = $_POST['quantity'];

        $total_price = 0;

        foreach ($products as $product_id) {
            $quantity = isset($quantities[$product_id]) ? intval($quantities[$product_id]) : 1;

            $query = "SELECT price FROM products WHERE product_id = $product_id";
            $result = mysqli_query($connection, $query);
            $product = mysqli_fetch_assoc($result);
	    $product_price=$product['price'];

            if ($product) {
                $total_price += $product['price'] * $quantity;
            }
        }

        $order_query = "INSERT INTO orders (user_id, total_price, payment_method, order_status) VALUES ('$user_id', '$total_price', '$payment_method', 'pending')";
        $order_result = mysqli_query($connection, $order_query);

        if ($order_result) {
            $order_id = mysqli_insert_id($connection);

            foreach ($products as $product_id) {
                $quantity = isset($quantities[$product_id]) ? intval($quantities[$product_id]) : 1;

                $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$product_price')";
                mysqli_query($connection, $order_item_query);
            }

            echo "<div class='success'>Order successfully added! Total Price: $" . number_format($total_price, 2) . "</div>";
            echo "<meta http-equiv='refresh' content='2;url=addorder.php'>"; // Refresh after 2 seconds
        } else {
            $error = "Error creating order.";
        }
    }
}
?>

<div class="flexcol main center">
    <h1 class="title">Place Order</h1>
    <form action="placeorder.php" method="post" class="admin form" id="orderForm">
        <div class="in-section">
            <label class="in-label">Customer</label>
            <select name="user_id" required>
                <option value="">Select customer here</option>
                <?php 
                include "includes/getcustomers.php";
                while ($customer = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$customer['user_id']}'>{$customer['first_name']} {$customer['last_name']}</option>";
                } 
                ?>
            </select>
        </div>

        <div class="in-section">
            <label class="in-label">Payment Method</label>
            <select name="payment_method" required>
                <option value="">Select payment method</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="paypal">PayPal</option>
                <option value="apple_pay">Apple Pay</option>
                <option value="google_pay">Google Pay</option>
            </select>
        </div>

        <div class="in-section">
            <label class="in-label">Order Items</label>
            <div class="gallery" id="productList">
                <?php
                include "includes/getproducts.php";
                while ($product = mysqli_fetch_assoc($result)) {
                    echo "<div class='card'>";
                    echo "<label>";
                    echo "<input type='checkbox' class='product-checkbox' name='products[]' value='{$product['product_id']}' data-price='{$product['price']}'>";
                    echo "<h4>{$product['name']}</h4>";
                    echo "<div class='sectrow'>";
                    echo "<h5><b>SKU:</b> {$product['sku']}</h5>";
                    echo "<h5><b>Price:</b> $<span class='product-price'>{$product['price']}</span></h5>";
                    echo "<img class='product-card-img' src='../public/{$product['image_url']}' alt='{$product['name']}'>";
                    echo "</div>";
                    echo "<input type='number' class='product-quantity' name='quantity[{$product['product_id']}]' value='1' min='1' disabled>";
                    echo "</label>";
                    echo "</div>";
                } ?>
            </div>
        </div>

        <div class="in-section">
            <label class="in-label">Total Price</label>
            <h3 id="totalPrice">$0.00</h3>
        </div>

        <input class="in-btn" type="submit" value="Place Order">
    </form>

    <?php if (!empty($error)) : ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll(".product-checkbox");
    const quantities = document.querySelectorAll(".product-quantity");
    const totalPriceElement = document.getElementById("totalPrice");

    function updateTotalPrice() {
        let total = 0;
        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                let price = parseFloat(checkbox.dataset.price);
                let quantity = parseInt(quantities[index].value);
                total += price * quantity;
            }
        });
        totalPriceElement.textContent = `$${total.toFixed(2)}`;
    }

    checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener("change", function() {
            quantities[index].disabled = !checkbox.checked;
            updateTotalPrice();
        });
    });

    quantities.forEach(quantity => {
        quantity.addEventListener("input", updateTotalPrice);
    });
});
</script>

<?php include "../includes/footer.php"; ?>
