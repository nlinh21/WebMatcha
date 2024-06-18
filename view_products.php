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
            <span>Our shop</span>
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
                                <div class  = "button">
                                    <button type = "submit" name = "add_to_cart"><i class = "bx bx-cart"></i></button>
                                    <button type = "submit" name = "add_to_wishlist"><i class = "bx bx-heart"></i></button>
                                    <a href = "view_page.php?pid=<?php echo $fetch_products['id']; ?>" class = "bx bxs-show"></a>
                                </div>
                                <h3 class  = "name">
                                    <?=$fetch_products['name']; ?>
                                </h3>
                                <input type = "hidden" name= "product_id" value = "<?=$fetch_products['id'];?>">
                                <div class = "fles">
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