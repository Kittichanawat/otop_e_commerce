<?php
// toggle_visibility.php

if (isset($_GET['mmb_id']) && isset($_GET['new_status'])) {
    $mmb_id = $_GET['mmb_id'];
    $new_status = $_GET['new_status'];

    // Include your database connection file
    require('../connectPDO/connnectpdo.php');

    try {
        // ใช้ prepared statement เพื่อป้องกัน SQL Injection
        $stmt = $conn->prepare("UPDATE member SET mmb_show = :new_status WHERE mmb_id = :mmb_id");
        $stmt->bindParam(':new_status', $new_status, PDO::PARAM_INT);
        $stmt->bindParam(':mmb_id', $mmb_id, PDO::PARAM_INT);
        $stmt->execute();

        // ส่ง HTTP response code 200 OK กลับไปที่ client
        http_response_code(200);
        // ส่งข้อความกลับไปที่ client (optional)
        echo json_encode(['message' => 'Update successful']);
    } catch (PDOException $e) {
        // กรณีเกิด error ในการ execute query
        // ส่ง HTTP response code 500 Internal Server Error กลับไปที่ client
        http_response_code(500);
        // ส่งข้อความ error กลับไปที่ client (optional)
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    } finally {
        // ปิดการเชื่อมต่อกับฐานข้อมูล
        $conn = null;
    }
} else {
    // กรณีไม่ได้รับค่า mmb_id หรือ new_status จาก client
    // ส่ง HTTP response code 400 Bad Request กลับไปที่ client
    http_response_code(400);
    // ส่งข้อความ error กลับไปที่ client (optional)
    echo json_encode(['error' => 'Bad Request']);
}
?>
