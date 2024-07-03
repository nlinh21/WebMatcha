<?php include 'components/connection.php'; 
session_start();
if(isset($_SESSION['user_id'])) {
    $user_id  = $_SESSION['user_id'];
} else {
    $user_id = '';
}
if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
}
//update product in cart
if(isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    $update_qty = $conn->prepare("UPDATE `cart` SET qty = ? WHERE id=?");
    $update_qty->execute([$qty, $cart_id]); 

    $success_msg[] = "Cart quantity update successfully";
}


// delete item from list
if(isset($_POST['delete_item'])) {
    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);

    $varify_delete_items = $conn->prepare("SELECT * FROM `cart` WHERE id=?");
    $varify_delete_items->execute([$cart_id]);

    if($varify_delete_items->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id=?");
        $delete_cart_id->execute([$cart_id]);
        $success_msg[] = "Cart item deleted successfully";
    } else {
        $warning_msg[] = "Cart item already deleted";
    }
}
//empty cart
if(isset($_POST['empty_cart'])) {
    $varify_empty_item = $conn->prepare("SELECT * FROM `cart` WHERE id=?");
    $varify_empty_item->execute([$user_id]);
    if($varify_empty_item->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM `cart` WHERE id=?");
        $delete_cart_id->execute([$user_id]);
        $success_msg[] = "Empty successfully";
    } else {
        $warning_msg[] = "Cart item already deleted";
    }

}



?>

<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Green Coffee - Cart Page</title>
</head>
<body>
    <?php include 'components/header.php'; ?>
    <div class="main">
        <div class="banner1">
            <img src="img/banner.jpg">
            <h1>My Cart</h1>
        </div>
        <div class="title2">
            <a href="home.php">Home</a>
            <span>/ Cart</span>
        </div>
        <section class="product-section">
            <h1 class="title">
                Products added in cart
            </h1>
            <div class="cart-products">
                <div class="cart-box-container">
                    <?php
                    $grand_total = 0;
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);
                    if ($select_cart->rowCount() > 0) {
                        while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                            $select_products->execute([$fetch_cart['product_id']]);
                            if ($select_products->rowCount() > 0) {
                                $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
                    ?>
                                <form action="" method="post" class="cart-box">
                                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                                    <img src="img/<?= $fetch_products['image']; ?>" class="cart-img">
                                    <h3 class="cart-name"><?= $fetch_products['name']; ?></h3>
                                    <div class="cart-flex">
                                        <p class="cart-price"><?= $fetch_products['price']; ?>/-</p>
                                        <input type="number" name="qty" required min="1" value="<?= $fetch_cart['qty']; ?>" max="99" maxlength="2" class="cart-qty">
                                        <button type="submit" name="update_cart" class="cart-edit-btn"></button>
                                    </div>
                                    <p class="cart-subtotal">
                                        Sub Total: <span><?= $sub_total = ($fetch_cart['qty'] * $fetch_products['price']) ?>/-</span>
                                    </p>
                                    <button type="submit" name="delete_item" class="cart-delete-btn" onclick="return confirm('Delete this item?')">Delete</button>
                                </form>
                    <?php
                                $grand_total += $sub_total;
                            } else {
                                echo '<p class="empty">Product was not found</p>';
                            }
                        }
                    } else {
                        echo '<p class="empty">No Products added yet!</p>';
                    }
                    ?>
                </div>
                <div class="cart-total">
                    <p>Total: <span><?= $grand_total; ?>/-</span></p>
                </div>
            </div>
            <?php
                if($grand_total != 0) {
                    ?>
                    <div class = "cart-total">
                        <p>Total amount payable: <span> $<?=$grand_total;?>/-</span> </p>
                       <div class="button">
                            <form method = "post">
                                <button tyoe = "submit" name="empty_cart" class = "btn" onclick = "return confirm ('are you sure to empty your cart')">
                                Empty Cart
                                </button> 
                            </form>
                            <a href = "checkout.php" class ="btn"> Proceed To Checkout</a>
                       </div>
                    </div>
                    <?php
                }
            ?>
        </section>
        <?php include 'components/footer.php'; ?>
    </div>

    <script src=""></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>
</body>
</html>
