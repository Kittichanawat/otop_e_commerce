<?php
require_once('../../../connect/connect.php');

if (isset($_GET['a_id'])) {
    $a_id = $_GET['a_id'];

    // ตรวจสอบว่า a_id มีค่าเป็นตัวเลข
    if (!is_numeric($a_id)) {
        echo json_encode(['success' => false, 'message' => 'รหัสข้อมูลไม่ถูกต้อง']);
        exit;
    }

    // ดึงข้อมูลไฟล์รูปภาพก่อนลบข้อมูลจากฐานข้อมูล
    $getImageSql = "SELECT a_img FROM about WHERE a_id = $a_id";
    $imageResult = $proj_connect->query($getImageSql);

    if ($imageResult->num_rows > 0) {
        $row = $imageResult->fetch_assoc();
        $imageToDelete = $row['a_img'];

        // ลบไฟล์รูปภาพ
        if (file_exists($imageToDelete)) {
            unlink($imageToDelete);
        }
    }

    // สร้างคำสั่ง SQL สำหรับลบข้อมูลที่มี a_id ที่ระบุ
    $deleteSql = "DELETE FROM about WHERE a_id = $a_id";

    if ($proj_connect->query($deleteSql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $proj_connect->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'รหัสข้อมูลไม่ถูกต้อง']);
}
?>
