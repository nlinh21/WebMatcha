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
/* ADD  Product in list*/
if(isset($_POST['add_to_wishlist'])){
    // Hàm để tạo unique ID
    function unique_id() {
        return uniqid(); // Sử dụng uniqid() để tạo unique ID
    }

    $user_id = $_SESSION['user_id']; // Đảm bảo bạn đã có $user_id từ session hoặc nơi khác

    $id = unique_id(); // Tạo unique ID
    $product_id = $_POST['product_id'];

    // Kiểm tra xem sản phẩm đã có trong wishlist của người dùng hay chưa
    $varify_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $varify_wishlist->execute([$user_id, $product_id]);

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng hay chưa
    $cart_num = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $cart_num->execute([$user_id, $product_id]);

    if($varify_wishlist->rowCount() > 0){
        $warning_msg[] = 'Product already exists in your wishlist';
    } elseif ($cart_num->rowCount() > 0) {
        $warning_msg[] = 'Product already exists in your cart';
    } else {
        // Lấy giá của sản phẩm từ bảng products
        $select_price = $conn->prepare("SELECT * FROM `products` WHERE id = ? LIMIT 1");
        $select_price->execute([$product_id]);
        $fetch_price =  $select_price->fetch(PDO::FETCH_ASSOC);

        // Thêm sản phẩm vào wishlist
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (id, user_id, product_id, price) VALUES (?,?,?, ?)");
        $insert_wishlist->execute([$id, $user_id, $product_id, $fetch_price['price']]);
        $success_msg[] = 'Product added to wishlist successfully';
    }
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
        <title>Green Coffee - Product Detail Page</title>
    </head>
    <body>
    <?php include 'components/header.php'; ?>
    <div class  ="main">
    <div class = "banner1">
            <img src = "img/banner.jpg">
            <h1>Product Detail</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a>
            <span>/ Product Detail</span>
        </div>
        <section class="view_page">
    <?php 
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = '$pid'");
            $select_products->execute();
            if($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form method="post">
                        <img src="img/<?php echo $fetch_products['image']; ?>">
                        <div class="detail">
                            <div class="price">
                                $<?php echo $fetch_products['price']; ?>/-
                            </div>
                            <div class="name">
                                <?php echo $fetch_products['name']; ?>
                            </div>
                            <div class="description">
                                <p>Matcha is a pure Japanese green tea made from finely ground powdered tea leaves. It is renowned for its rich antioxidant content and nutritional benefits, containing high levels of polyphenols, catechins, and EGCG compounds. Not only prized for its delicate flavor and vibrant green color, matcha is celebrated for its potential health benefits, including enhanced focus and relaxation. Enjoying matcha is also a part of Japanese tea ceremonies, where it is revered and cherished for promoting calmness and tranquility of the mind.</p>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                            <div class="button">
                                <button type="submit" name="add_to_wishlist" class="btn">
                                    Add to wishlist
                                    <i class="bx bx-heart"></i>
                                </button>
                                <input type="hidden" name="qty" value="1" min="0" class="quantity">
                                <button type="submit" name="add_to_cart" class="btn">
                                    Add to Cart
                                    <i class="bx bx-cart"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            }
        }
    ?>
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