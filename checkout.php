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
if(isset($_POST['place_order'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $address = $_POST['flat'].','.$_POST['street'].','.$_POST['city'].','.$_POST['country'].','.$_POST['pincode'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $address_type = $_POST['address_type'];
    $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);

    $varify_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id=?");
    $varify_cart->execute([$user_id]);

    if(isset($_GET['get_id'])){
        $get_product = $conn->prepare("SELECT * FROM `products` WHERE id=? LIMIT 1");
        $get_product->execute([$user_id]);
        if($get_product -> rowCount() > 0) {
            while($fetch_p = $get_product ->fetch(PDO::FETCH_ASSOC)){
                $insert_order = $conn -> prepare("INSERT INTO `order` (id, 
                user_id, name, number, email, address, address_type, $method,
                 product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'],1]);
                header('location: order.php');
            }
        } else{
            $warning_msg[] = 'somthing went wrong';
        }
    } else if($varify_cart->rowCount() > 0){
        while($f_cart = $varify_cart ->  fetch(PDO::FETCH_ASSOC)){
            $insert_order = $conn -> prepare("INSERT INTO `order` (id, 
            user_id, name, number, email, address, address_type, $method,
             product_id, price, qty) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $f_cart['price'],$f_cart['qty']]);
            header('location: order.php');
        }
        if($insert_order){
            $delete_cart_id = $conn -> prepare("DELETE FROM `cart` WHERE user_id = ? ");
            $delete_cart_id -> execute([$user_id]);
            header('location: order.php');
        }
    }else {
        $warning_msg[] = 'somthing went wrong';
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
        <title>Green Coffee - Checkout Page</title>
    </head>
    <body>
    <?php include 'components/header.php'; ?>
    <div class  ="main">
    <div class = "banner1">
            <img src = "img/banner.jpg">
            <h1> Checkout Sumary</h1>
        </div>
        <div class = "title2">
            <a href = "home.php">Home</a>
            <span>/ Checkout Sumary</span>
        </div>
        <section class = "checkout">
            <div class  = "title">
                <img src="img/download.png" class  ="logo">
                <h1>Checkout Sumary</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                </div>
                <div class ="row">
                    <form method="post">
                        <h3>Billing Details</h3>
                        <div class ="flex">
                            <div class= "box">
                                <div class  ="input-field">
                                    <p>Your Name <span>*</span></p>
                                    <input type="text" name="name" require maxlength = "50" 
                                    placeholder = "Enter Your Name" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>Your Number <span>*</span></p>
                                    <input type="number" name="number" require maxlength = "10" 
                                    placeholder = "Enter Your Number" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>Your Email <span>*</span></p>
                                    <input type="email" name="email" require maxlength = "50" 
                                    placeholder = "Enter Your Email" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>Payment method<span>*</span></p>
                                    <select name="method" class="input">
                                        <option  value="cash on delivery">Cash On Delivery</option>
                                        <option  value="credit or debit card">credit or debit card</option>
                                        <option  value="net banking">net banking</option>
                                        <option  value="UPI or Rupay">UPI or Rupay</option>
                                        <option  value="paytm">paytm</option>
                                    </select>
                                </div>
                                <div class  ="input-field">
                                    <<p>Address Type<span>*</span></p>
                                    <select name="address_type" class="input">
                                        <option  value="home">Home</option>
                                        <option  value="office">Office</option>
                                    </select>
                                </div>
                            </div>
                            <div class  ="box">
                            <div class  ="input-field">
                                    <p>Address line 01 <span>*</span></p>
                                    <input type="text" name="flat" require maxlength = "50" 
                                    placeholder = "e.g flat & building number" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>Address line 02 <span>*</span></p>
                                    <input type="text" name="streat" require maxlength = "50" 
                                    placeholder = "e.g streat name" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>City Name<span>*</span></p>
                                    <input type="text" name="city" require maxlength = "50" 
                                    placeholder = "Enter Your City Name" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>Country Name<span>*</span></p>
                                    <input type="text" name="city" require maxlength = "50" 
                                    placeholder = "Enter Your Country Name" class  ="input">
                                </div>
                                <div class  ="input-field">
                                    <p>PinCode<span>*</span></p>
                                    <input type="text" name="pincode" require maxlength = "6" 
                                    placeholder = "123455" min="0" max="9" class  ="input">
                                </div>
                            </div>
                        </div>
                        <button type= "submit" name="place_order" class = "btn">
                            Place Order
                        </button>
                    </form>
                    <div class = "sumary">
                        <h3>My Bag</h3>
                        <div class  = "box-container">
                            <?php
                                $grand_total=0;
                                if(isset($_GET['get_id'])){
                                    $select_get = $conn->prepare("SELECT * FROM `products` WHERE id=?");
                                    $select_get->execute([$_GET['get_id']]);
                                    while($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)){
                                        $sub_total  = $fetch_get['price'];
                                        $grand_total+=$sub_total;
                            ?>
                            <div class  ="flex">
                                <img src= "img/<?=$fetch_get['image'];?>" class ="image">
                                <div>
                                    <h3 class ="name"><?=$fetch_get['name']?></h3>
                                    <p class ="price"><?=$fetch_get['price']?>/-</p>
                                </div>
                            </div>
                            <?php
                                    }
                                } else {
                                    $select_cart = $conn ->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                                    $select_cart->execute ([$user_id]);
                                    if($select_cart->rowCount()>0){
                                        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                                            $select_products = $conn -> prepare ("SELECT * FROM `products` WHERE id = ?");
                                            $select_products->execute([$fetch_cart['product_id']]);
                                            $fetch_product = $select_products -> fetch(PDO::FETCH_ASSOC);
                                            $sub_total = ($fetch_cart['qty'] * $fetch_product['price']);
                                            $grand_total += $sub_total;
                              
                            ?>
                            <div class  = "flex">
                                <img src="img/<?=$fetch_product['image']?>">
                                <div>
                                    <h3 class ="name"><?=$fetch_product['name']?></h3>
                                    <p class ="price"><?=$fetch_product['price']?> X <?=$fetch_cart['qty']?></p>
                                </div>
                            </div>
                            <?php
                                      }
                                    }else{
                                        echo '<p class = "empty"> your cart is empty</p>';
                                    }
                                }
                            ?>
                        </div>
                        <div class  = "grand-totral"><span>Total Amount Payable: </span>$<?=$grand_total?>/-</div>
                    </div>
                
            </div>
        </section>
        
        <?php include 'components/footer.php';?>
    </div>
        
        <script src = ""></script>
        <script src = "script.js"></script>
        <?php include 'components/alert.php'; ?>
    </body>
</html>