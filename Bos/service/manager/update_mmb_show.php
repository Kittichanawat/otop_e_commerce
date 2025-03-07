<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');
require_once('../../pages/authen.php'); // รวมไฟล์เชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // รับค่า JSON ที่ส่งมาจาก JavaScript
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, TRUE);

    // ดึงค่า id และ mmb_show จาก JSON
    $id = $input['id'];
    $mmb_show = $input['mmb_show'];

    // เชื่อมต่อฐานข้อมูล
    $Database = new Database();
    $conn = $Database->connect();

    // อัปเดตค่า mmb_show ในฐานข้อมูล
    $update_stmt = $conn->prepare("UPDATE member SET mmb_show = :mmb_show WHERE mmb_id = :id");
    $update_stmt->bindParam(':mmb_show', $mmb_show, PDO::PARAM_INT);
    $update_stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        // อัปเดตสำเร็จ
        http_response_code(200); // ส่งรหัสสถานะ 200 (OK)
    } else {
        // อัปเดตไม่สำเร็จ
        http_response_code(500); // ส่งรหัสสถานะ 500 (Internal Server Error)
    }
} else {
    // ไม่ใช่เมธอด PUT ไม่ต้องทำอะไร
    http_response_code(405); // ส่งรหัสสถานะ 405 (Method Not Allowed)
}
?>
