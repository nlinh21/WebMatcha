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
        <title>Green Coffee - Home Page</title>
    </head>
    <body>
    <?php include 'components/header.php'; ?>
    <div class  ="main">
    <div class = "banner1">
            <img src = "img/banner.jpg">
            <h1>Contact Us</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a>
            <span>Contact us</span>
        </div>
        <section class  = "services">
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
    <div class="main-container">
    <div class="form-container">
        <form method="post">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Leave a Message</h1>
            </div>
            <div class="input-field">
                <p>Your name </p>
                <input type="text" name="name">
            </div>
            <div class="input-field">
                <p>Your email </p>
                <input type="email" name="email">
            </div>
            <div class="input-field">
                <p>Your number </p>
                <input type="text" name="number">
            </div>
            <div class="input-field">
                <p>Your message</p>
                <textarea name="message"></textarea>
            </div>
            <button type="submit" name="submit-btn" class="btn">Send Message</button>
        </form>
    </div>
</div>
<div class  ="address">
            <div class="title">
                <img src="img/download.png" class="logo">
                <h1>Contact detail</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, Lorem ipsum dolor sit amet</p>
            </div>
            <div class  = "box-container">
                <div class  = "box">
                    <img src="img/address3.png" alt="Address Icon" class="box-image">
                    <i class = "bx bxs-map-pin" ></i>
                    <div>
                        <h4>Address</h4>
                        <p>1092 Merigold Lane, Coral Way</p>
                    </div>
                </div>
                <div class  = "box">
                <img src="img/phone.png" alt="Phone Icon" class="box-image">
                    <i class = "bx bxs-phone-call" ></i>
                    <div>
                        <h4>Phone Number</h4>
                        <p>0123456789</p>
                    </div>
                </div>
                <div class  = "box">
                <img src="img/email.png" alt="Email Icon" class="box-image">
                    <i class = "bx bxs-map-pin" ></i>
                    <div>
                        <h4>Email</h4>
                        <p>greentea@contact.com</p>
                    </div>
                </div>
            </div>
        </div>
    
    <?php 
            include 'components/footer.php';
        ?>
    </div>
   
        <script src = ""></script>
        <script src = "script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>