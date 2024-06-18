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
        <title>Green Coffee - About Us Page</title>
    </head>
    <body>
        <?php include 'components/header.php'; ?>
    <div class  ="main">
        <div class = "banner1">
            <img src = "img/banner.jpg">
            <h1>About Us</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a>
            <span>About</span>
        </div>
        <div class  = "about-category">
            <div class = "box">
                <img src = "img/3.webp">
                <div class = "detail">
                    <span> Coffee</span>
                    <h1>Lemon Green</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
            <div class = "box">
                <img src = "img/2.webp">
                <div class = "detail">
                    <span> Coffee</span>
                    <h1>Lemon Green</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
            <div class = "box">
                <img src = "img/about.png">
                <div class = "detail">
                    <span> Coffee</span>
                    <h1>Lemon Tea</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
            <div class = "box">
                <img src = "img/1.webp">
                <div class = "detail">
                    <span> Coffee</span>
                    <h1>Lemon Green</h1>
                    <a href = "view_products.php" class = "btn">Shop Now</a>
                </div>
            </div>
        </div>
        <section class  = "services">
            <div class  = "title">
                <img src = "img/download.png" class = "logo">
                <h1>Why Choose us</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
            </div>
        <div class = "box-container">
            <div class = "box">
            <img src = "img/icon2.png">
                <div class = "detail">
                    <h3>great savings</h3>
                    <p>save big every order</p>
                </div>
            </div>
            <div class = "box">
            <img src = "img/icon1.png">
                <div class = "detail">
                    <h3>24/7 support</h3>
                    <p>one-on-one support</p>
                </div>
            </div>
            <div class = "box">
            <img src = "img/icon0.png">
                <div class = "detail">
                    <h3>gift vouchers</h3>
                    <p>vouchers on every fesvivals</p>
                </div>
            </div>
            <div class = "box">
            <img src = "img/icon.png">
                <div class = "detail">
                    <h3>worldwide delivery</h3>
                    <p>dropship worldwide</p>
                </div>
            </div>
        </div>
    </section>
    <div class = "about">
        <div class = "row">
            <div class = "img-box">
                <img src ="img/3.png">
            </div>
            <div class = "detail">
                <h1> Visit our beatiful showroom</h1>
                <p>Our showroom is an expression of what we love doing; being create with floral and plant arrangements.
                    Whether you are looking for a florist for your perfect wedding, or just want to uplift anyy room with some one of a kind living decor, Blossom With Love can help.
                </p>
                <a href = "view_products.php" class = "btn">Shop now</a>
            </div>
        </div>
        <div class = "testtimonial-container">
        <div class = "title">
            <img src ="img/download.png" class  ="logo">
            <h1>What people say about us</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
        <div class = "container">
            <div class = "testimonial-item active">
                <img src = "img/01.jpg">
                <h1>Sara smith</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>        
            </div>
            <div class = "testimonial-item">
                <img src = "img/02.jpg">
                <h1>John smith</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>        
            </div>
            <div class = "testimonial-item">
                <img src = "img/03.jpg">
                <h1>Selena Ansari</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>        
            </div>
            <!-- <div class  = "left-arrow" onclick = "nextSlide()">
                <i class = "bx bx-left-arrow-alt"></i>
            </div>
            <div class  = "right-arrow" onclick = "prevSlide()">
                <i class = "bx bx-right-arrow-alt"></i>
            </div> -->
            </div>
        </div>

        </div>

        <?php include 'components/footer.php';?>
</div>

        <script src = ""></script>
        <script src = "script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>