<?php
require_once('../../../connect/connect.php');

if (isset($_GET['h_id'])) {
    $h_id = $_GET['h_id'];

    // ตรวจสอบว่า id มีค่าเป็นตัวเลข
    if (!is_numeric($h_id)) {
        echo json_encode(['success' => false, 'message' => 'รหัสข้อมูลไม่ถูกต้อง']);
        exit;
    }

    // ดึงข้อมูลไฟล์รูปภาพก่อนลบข้อมูลจากฐานข้อมูล
    $getImageSql = "SELECT h_img FROM history WHERE h_id = $h_id";
    $imageResult = $proj_connect->query($getImageSql);

    if ($imageResult->num_rows > 0) {
        $row = $imageResult->fetch_assoc();
        $imageToDelete = $row['h_img'];

        // ลบไฟล์รูปภาพ
        if (file_exists($imageToDelete)) {
            unlink($imageToDelete);
        }
    }

    // สร้างคำสั่ง SQL สำหรับลบข้อมูลที่มี id ที่ระบุ
    $deleteSql = "DELETE FROM history WHERE h_id = $h_id";

    if ($proj_connect->query($deleteSql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $proj_connect->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'รหัสข้อมูลไม่ถูกต้อง']);
}
?>