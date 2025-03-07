<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "otop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าที่ถูกส่งมาจาก AJAX
$query = $_POST['query'];

// ค้นหาข้อมูลจากฐานข้อมูล
$sql = "SELECT prd_id, prd_name, prd_img FROM product WHERE prd_name LIKE '%$query%'";
$result = $conn->query($sql);

// แสดงผลลัพธ์
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // เพิ่ม HTML สำหรับแสดงผลลัพธ์
        echo '<div class="product-item" data-id="' . $row['prd_id'] . '" data-name="' . $row['prd_name'] . '" data-image="' . $row['prd_img'] . '">';
        echo '<img src="startbootstrap-sb-admin-2-gh-pages/pages/product/' . $row['prd_img'] . '" alt="' . $row['prd_name'] . '" style="max-width: 50px; max-height: 50px;">';
        echo '<span>' . $row['prd_name'] . '</span>';
        echo '</div>';
    }
} else {
    echo 'ไม่พบข้อมูลสินค้า';
}

$conn->close();
?>
