<header class = "header">
    <div class =  "flex">
        <a href = "home.php" class = "logo">
            <img src = "img/logo.jpg">
        </a>
        <nav class = "navbar">
            <a href = "home.php"> home</a>
            <a href = "view_products.php">product</a>
            <a href = "order.php">order</a>
            <a href = "about.php"> about us</a>
            <a href = "contact.php"> contact us</a>
        </nav>
        <div class="icons">
    <!-- Biểu tượng người dùng -->
    <a href="#" id="user-btn" class="icon-link">
        <img src="img/user.png" alt="User" class="icon-img">
    </a>
    
    <!-- Biểu tượng danh sách ưa thích -->
    <a href="wishlist.php" class="cart-btn icon-link">
        <img src="img/heart.png" alt="Wishlist" class="icon-img">
        <sup>0</sup>
    </a>
    
    <!-- Biểu tượng giỏ hàng -->
    <a href="cart.php" class="cart-btn icon-link">
        <img src="img/trolley.png" alt="Cart" class="icon-img">
        <sup>0</sup>
    </a>
    
    <!-- Biểu tượng menu -->
    <i class = "bx bx-list-plus" id = "menu-btn" style = "font-size: 2rem;"></i>
    <a id="menu-btn" class="icon-link">
        <img src="img/list.png" alt="menu" class="icon-img" style="font-size: 2rem;">
    </a>
</div>
        <div class= "user-box">
            <p>username: <span> <?php echo $_SESSION['user_name']; ?></span></p>
            <p>email: <span> <?php echo $_SESSION['user_email']; ?></span></p>
            <a href = "login.php" class = "btn"> login</a>
            <a href = "register.php" class = "btn"> register</a>
            <form method = "post">
                <button type = "summit" name = "logout" class  ="logout-btn"> logout</button>
            </form>
        </div>
    </div>
</header>