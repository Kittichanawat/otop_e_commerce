<?php
// นำเข้าไฟล์ connect.php หรือไฟล์ที่มีการเชื่อมต่อฐานข้อมูล
require('connect.php');

// ตรวจสอบว่ามีการส่งค่า mmb_id และ action มาหรือไม่
if (isset($_POST['mmb_id'], $_POST['action'])) {
    $mmb_id = $_POST['mmb_id'];
    $action = $_POST['action'];

    // ตรวจสอบ action ที่ส่งมา
    if ($action === 'hide') {
        $mmb_show = 0;
    } elseif ($action === 'show') {
        $mmb_show = 1;
    } else {
        echo 'Invalid action';
        exit;
    }

    // อัพเดทค่า mmb_show ในฐานข้อมูล
    $update_query = "UPDATE member SET mmb_show = $mmb_show WHERE mmb_id = $mmb_id";
    $update_result = mysqli_query($proj_connect, $update_query);

    if ($update_result) {
        echo 'Success';
    } else {
        echo 'Error updating status';
    }
} else {
    echo 'Invalid request';
}
?>
