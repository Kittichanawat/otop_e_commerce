<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');
require_once('../../pages/authen.php'); // รวมไฟล์เชื่อมต่อฐานข้อมูล

session_start(); // เริ่มเซสชัน (หากยังไม่ได้ทำ)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่ามีเซสชันอยู่และสถานะเป็น "superadmin" หรือไม่
    if (isset($_SESSION['status']) && $_SESSION['status'] === 'superadmin') {
        // รับข้อมูลที่ส่งมาจากแบบฟอร์ม
        $mmb_name = $_POST['mmb_name'];
        $mmb_surname = $_POST['mmb_surname'];
        $mmb_username = $_POST['mmb_username'];
        $mmb_pwd = $_POST['mmb_pwd'];
        $status = $_POST['status'];
        $mmb_phone = $_POST['mmb_phone'];
        $mmb_addr = $_POST['mmb_addr'];
        $mmb_email = $_POST['mmb_email'];

        // เชื่อมต่อกับฐานข้อมูล
        $Database = new Database();
        $conn = $Database->connect();

        // เตรียมคำสั่ง SQL INSERT เพื่อเพิ่มข้อมูลในตาราง member
        $insert_stmt = $conn->prepare("INSERT INTO member (mmb_name, mmb_surname, mmb_username, mmb_pwd, status, mmb_phone,mmb_addr, mmb_email) VALUES (:mmb_name, :mmb_surname, :mmb_username, :mmb_pwd, :status, :mmb_phone,:mmb_addr, :mmb_email)");
        $insert_stmt->bindParam(':mmb_name', $mmb_name, PDO::PARAM_STR);
        $insert_stmt->bindParam(':mmb_surname', $mmb_surname, PDO::PARAM_STR);
        $insert_stmt->bindParam(':mmb_username', $mmb_username, PDO::PARAM_STR);
        $insert_stmt->bindParam(':mmb_pwd', $mmb_pwd, PDO::PARAM_STR);
        $insert_stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $insert_stmt->bindParam(':mmb_phone', $mmb_phone, PDO::PARAM_STR);
        $insert_stmt->bindParam(':mmb_addr', $mmb_addr, PDO::PARAM_STR);
        $insert_stmt->bindParam(':mmb_email', $mmb_email, PDO::PARAM_STR);

        if ($insert_stmt->execute()) {
            // การเพิ่มข้อมูลสำเร็จ
            echo 'success'; // ส่ง 'success' กลับไปยัง JavaScript เมื่อเพิ่มข้อมูลสำเร็จ
        } else {
            // การเพิ่มข้อมูลไม่สำเร็จ
            http_response_code(500); // ส่งรหัสสถานะ 500 (Internal Server Error)
            echo 'error'; // ส่ง 'error' กลับไปยัง JavaScript เมื่อเพิ่มข้อมูลไม่สำเร็จ
        }
    } else {
        // ไม่มีสิทธิ์ในการเพิ่มข้อมูล
        http_response_code(403); // ส่งรหัสสถานะ 403 (Forbidden)
        echo 'forbidden'; // ส่ง 'forbidden' กลับไปยัง JavaScript เมื่อไม่มีสิทธิ์ในการเพิ่มข้อมูล
    }
} else {
    // ถ้าเมธอดของคำขอไม่ใช่ POST ให้ส่งรหัสสถานะ 405 (Method Not Allowed)
    http_response_code(405); // ส่งรหัสสถานะ 405 (Method Not Allowed)
    echo 'method_not_allowed'; // ส่ง 'method_not_allowed' กลับไปยัง JavaScript เมื่อเมธอดไม่ถูกต้อง
}
?>
