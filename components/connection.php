<?php
// components/connection.php
$host = 'localhost';
$dbname = 'shop_db'; // Thay 'ten_cau_hinh' bằng tên cơ sở dữ liệu của bạn
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

?>