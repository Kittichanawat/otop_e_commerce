<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');
require_once('../../pages/authen.php'); // รวมไฟล์เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // รับค่า 'id' จาก query parameter
    $id = $_GET['id']; // เปลี่ยนจาก $_REQUEST เป็น $_GET

    // เชื่อมต่อกับฐานข้อมูล
    $Database = new Database();
    $conn = $Database->connect();

    // ตรวจสอบสิทธิ์การลบ และรหัสผ่านของผู้ใช้ที่ลงชื่อเข้าใช้ (ตามความต้องการ)
    
    // ตรวจสอบสิทธิ์การลบและอื่น ๆ ตามความต้องการ

    // ถ้ามีสิทธิ์ในการลบรายการนี้
    $hasPermissionToDelete = true; // เช่นมีสิทธิ์ทั้งหมด

    if ($hasPermissionToDelete) {
        // อัปเดตคำสั่ง SQL DELETE เพื่อลบบัญชีจากตาราง member โดยใช้พารามิเตอร์ :id
        $delete_stmt = $conn->prepare("DELETE FROM member WHERE mmb_id = :id");
        $delete_stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($delete_stmt->execute()) {
            // การลบสำเร็จ
            http_response_code(200); // ส่งรหัสสถานะ 200 (OK)
        } else {
            // การลบไม่สำเร็จ
            http_response_code(500); // ส่งรหัสสถานะ 500 (Internal Server Error)
        }
    } else {
        // ไม่มีสิทธิ์ในการลบรายการนี้
        http_response_code(403); // ส่งรหัสสถานะ 403 (Forbidden)
    }
} else {
    // ถ้าเมธอดของคำขอไม่ใช่ DELETE ให้ส่งรหัสสถานะ 405 (Method Not Allowed)
    http_response_code(405); // ส่งรหัสสถานะ 405 (Method Not Allowed)
}
?>
