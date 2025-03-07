<?php
// เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อตามของคุณ)
require('connect/connect.php');

// ตรวจสอบว่ามีการส่งคำร้องขอ POST และรับค่า cartId จากคำร้องขอ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartId'])) {
    $cartId = $_POST['cartId'];

    // สร้างคำสั่ง SQL สำหรับลบรายการตาม cart_id
    $sql = "DELETE FROM cart WHERE crt_id = $cartId";

    if ($proj_connect->query($sql) === TRUE) {
        // ถ้าลบสำเร็จ ส่งคำตอบกลับเป็น JSON บอกว่าลบสำเร็จ
        $response = ['success' => true];
    } else {
        // ถ้าเกิดข้อผิดพลาดในการลบ ส่งคำตอบกลับเป็น JSON บอกว่ามีข้อผิดพลาด
        $response = ['success' => false, 'message' => 'ไม่สามารถลบรายการได้: ' . $proj_connect->error];
    }
} else {
    // ถ้าไม่มีการส่งคำร้องขอ POST หรือไม่มี cartId ส่งมา
    $response = ['success' => false, 'message' => 'ไม่ได้รับข้อมูลในคำร้องขอ'];
}

// ตั้งค่าหัวตอบกลับให้เป็น JSON
header('Content-Type: application/json');

// ส่งคำตอบกลับในรูปแบบ JSON
echo json_encode($response);
?>
