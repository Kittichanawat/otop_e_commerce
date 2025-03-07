<?php
require_once('../../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);

    $mmb_id = $_PUT['mmb_id'];
    $mmb_name = $_PUT['mmb_name'];
    $mmb_surname = $_PUT['mmb_surname'];
    $status = $_PUT['status'];
    $mmb_phone = $_PUT['mmb_phone'];
    $mmb_email = $_PUT['mmb_email'];

    // สร้างคำสั่ง SQL สำหรับการอัปเดตข้อมูล
    $update_sql = "UPDATE member SET mmb_name = ?, mmb_surname = ?, status = ?, mmb_phone = ?, mmb_email = ? WHERE mmb_id = ?";
    $stmt = mysqli_prepare($proj_connect, $update_sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssi", $mmb_name, $mmb_surname, $status, $mmb_phone, $mmb_email, $mmb_id);

        if (mysqli_stmt_execute($stmt)) {
            // อัปเดตข้อมูลสำเร็จ
            echo json_encode(['message' => 'อัปเดตข้อมูลสำเร็จ']);
        } else {
            // อัปเดตข้อมูลไม่สำเร็จ
            echo json_encode(['error' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล: ' . mysqli_error($proj_connect)]);
        }

        mysqli_stmt_close($stmt);
    } else {
        // เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL
        echo json_encode(['error' => 'เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: ' . mysqli_error($proj_connect)]);
    }

    mysqli_close($proj_connect);
} else {
    // ไม่ใช่เมธอด HTTP PUT
    echo json_encode(['error' => 'เมธอดไม่ถูกต้อง']);
}
?>
