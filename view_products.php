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
        <title>Green Coffee - Shop Page</title>
    </head>
    <body>
    <?php include 'components/header.php'; ?>
    <div class  ="main">
    <div class = "banner1">
            <img src = "img/banner.jpg">
            <h1> Shop</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a>
            <span>/ Our shop</span>
        </div>
        <section class = "products">
            <div class = "box-container">
                <?php
                    $select_products = $conn -> prepare("SELECT * FROM products");
                    $select_products -> execute();
                    if($select_products ->rowCount() > 0){
                        while ($fetch_products =$select_products -> fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <form action = "" method = "post" class = "box">
                                <img src = "img/<?=$fetch_products['image']; ?>" class = "img">
                     
                                <div class="button">
                                <button type="submit" name="add_to_cart">
                                    <img src="img/trolley.png" alt="Add to Cart" class="icon">
                                </button>
                                <button type="submit" name="add_to_wishlist">
                                    <img src="img/heart1.png" alt="Add to Wishlist" class="icon">
                                </button>
                                <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>">
                                    <img src="img/info.png" alt="View Product" class="icon">
                                </a>
                            </div>
                            <h3 class="name">
                                <?=$fetch_products['name']; ?>
                            </h3>
                            <input type="hidden" name="product_id" value="<?=$fetch_products['id'];?>">

                                <div class = "flex">
                                    <p class = "price"> Price $<?=$fetch_products['price'];?>/-</p>
                                    <input type = "number" name = "qty" require min= "1" value ="1" max ="99" maxlegth = "2">
                                </div>
                                <a href = "checkout.php? get_id=<?=$fetch_products['id'];?>" class = "btn"> Buy Now</a>
                                <p class = "empty"> No Products added yet!</p>
                            </form>
                            <?php
                        } 
                    }else{
                        echo '<p class = "empty"> No Products added yet!</p>';
                    }
                ?>

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