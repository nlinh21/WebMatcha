<?php include 'components/connection.php'; 
session_start();
if(isset($_SESSION['user_id'])) {
    $user_id  = $_SESSION['user_id'];
}
else{
    $user_id = '';
}
if(isset($_POST['logout'])){
    session_destroy();
    header("location: login.php");
}

/* ADD  Product in cart*/
if(isset($_POST['add_to_cart'])){
    // Hàm để tạo unique ID
    function unique_id() {
        return uniqid(); // Sử dụng uniqid() để tạo unique ID
    }

    $user_id = $_SESSION['user_id']; // Đảm bảo bạn đã có $user_id từ session hoặc nơi khác

    $id = unique_id(); // Tạo unique ID
    $product_id = $_POST['product_id'];

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng hay chưa
    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $varify_cart->execute([$user_id, $product_id]);

    $max_cart_items = $conn-> prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if($varify_cart->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your wishlist';
    } elseif ($max_cart_items->rowCount() > 20) {
        $warning_msg[] = 'cart is full';
    } else {
        // Lấy giá của sản phẩm từ bảng products
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price =  $select_price->fetch(PDO::FETCH_ASSOC);

        // Thêm sản phẩm vào wishlist
        $insert_cart = $conn->prepare("INSERT INTO `cart` (id, user_id, product_id, price, qty) VALUES (?,?,?,?,?)");
        $insert_cart->execute([$id, $user_id, $product_id, $fetch_price['price'], $qty]);
        $success_msg[] = 'Product added to cart successfully';
    }
}
// delete item from list
if(isset($_POST['delete_item'])) {
    $wishlist_id =$_POST['wishlist_id'];
    $wishlist_id = filter_var($wishlist_id, FILTER_SANITIZE_STRING);

    $varify_delete_items = $conn->prepare("SELECT * FROM `wishlist` WHERE id=?");
    $varify_delete_items->execute([$wishlist_id]);

    if($varify_delete_items -> rowCount() > 0){
        $delete_wishlist_id = $conn -> prepare("DELETE FROM `wishlist` WHERE id= ?");
        $delete_wishlist_id->execute([$wishlist_id]);
        $success_msg[] = "wishlist item delete successfully";
    } else {
        $warning_msg[] = "wishlist item already deleted";
    }
}

?>

<style type="text/css">
      <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scal = 1.0">
        <link rel="stylesheet" href="style.css">
        <title>Green Coffee - Wishlist Page</title>
    </head>
    <body>
    <?php include 'components/header.php'; ?>
    <div class  ="main">
    <div class = "banner1">
            <img src = "img/banner.jpg">
            <h1>My Wishlist</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a>
            <span>/ Wishlist</span>
        </div>
        <section class="product">
            <h1 class = "title">
                Products added in wishlist
            </h1>
            <div class="products">
    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
        $select_wishlist->execute([$user_id]);
        if ($select_wishlist->rowCount() > 0) {
            while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                $select_products->execute([$fetch_wishlist['product_id']]); // Sửa lại chỗ này
                if ($select_products->rowCount() > 0) {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
        ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                        <img src="img/<?= $fetch_products['image']; ?>" class="img">
                        <div class="button">
                            <button type="submit" name="add_to_cart">
                                <img src="img/trolley.png" alt="Add to Cart" class="icon">
                            </button>
                            <a href="view_page.php?pid=<?= $fetch_products['id']; ?>">
                                <img src="img/info.png" alt="View Product" class="icon">
                            </a>
                            <button type="submit" name="delete_item" onclick="return confirm('delete this item');">
                                <img src="img/delete.png" alt="Delete wishlist" class="icon">
                            </button>
                        </div>
                        <h3 class="name"><?= $fetch_products['name']; ?></h3>
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                        <div class="flex">
                            <p class="price"><?= $fetch_products['price']; ?>/-</p>
                        </div>
                        <a href="checkout.php?get_id=<?= $fetch_products['id']; ?>" class="btn">Buy Now</a>
                    </form>
        <?php
                    $grand_total += $fetch_wishlist['price'];
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

        </section>
    <?php 
            include 'components/footer.php';
        ?>
    </div>
   
        <script src = ""></script>
        <script src = "script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>