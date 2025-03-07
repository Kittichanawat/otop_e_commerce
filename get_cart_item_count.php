<?php
// เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
require('connect.php');

// รับค่าจาก Session
session_start();

if (isset($_SESSION['mmb_id'])) {
    $mmb_id = $_SESSION['mmb_id'];
    // ดึงจำนวนสินค้าในตะกร้าของสมาชิก
    $sql = "SELECT COUNT(*) AS cartItemCount FROM cart WHERE mmb_id = $mmb_id";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cartItemCount = $row['cartItemCount'];
        echo json_encode(['success' => true, 'cartItemCount' => $cartItemCount]);
    } else {
        echo json_encode(['success' => true, 'cartItemCount' => 0]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ไม่พบรหัสสมาชิก']);
}
?>
