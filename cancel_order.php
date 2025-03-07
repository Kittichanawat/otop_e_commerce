<?php
require('connect.php'); // เชื่อมต่อฐานข้อมูล
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // อัปเดตสถานะคำสั่งซื้อเป็น 'ยกเลิก'
    $query = "UPDATE orders SET status = 'ยกเลิก' WHERE order_id = ?";
    $stmt = $proj_connect->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $proj_connect->close();
}
?>
