<?php
session_start(); // เริ่มต้น session หากยังไม่ได้เริ่มต้น

// เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
require('connect.php');

// รับค่าจาก URL
$prd_id = $_GET['prd_id'];
$mmb_id = $_GET['mmb_id'];
$pty_id = $_GET['pty_id'];
$crt_amount = $_GET['crt_amount'];
$prd_name = $_GET['prd_name'];
$item_totals = $_GET['item_totals'];

// ตรวจสอบว่าสินค้ามีอยู่ในตะกร้าหรือยัง
$sql = "SELECT * FROM cart WHERE prd_id = $prd_id AND mmb_id = $mmb_id";
$result = $proj_connect->query($sql);

if ($result->num_rows > 0) {
    // หากมีสินค้าอยู่ในตะกร้าแล้ว
    $existingCart = $result->fetch_assoc();
    $currentAmount = $existingCart['crt_amount'];
    $newAmount = $currentAmount + $crt_amount;

    $update_sql = "UPDATE cart SET crt_amount = $newAmount, prd_name = '$prd_name', item_totals = $item_totals WHERE prd_id = $prd_id AND mmb_id = $mmb_id";
    if ($proj_connect->query($update_sql) === TRUE) {
        $_SESSION['crt_success'] = true; // ตั้งค่า session crt_success
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถอัปเดตจำนวนสินค้าในตะกร้าได้']);
    }
} else {
    // หากยังไม่มีสินค้าในตะกร้า
    $insert_sql = "INSERT INTO cart (prd_id, mmb_id, pty_id, crt_amount, prd_name, item_totals) VALUES ($prd_id, $mmb_id, $pty_id, $crt_amount, '$prd_name', $item_totals)";
    if ($proj_connect->query($insert_sql) === TRUE) {
        $_SESSION['crt_success'] = true; // ตั้งค่า session crt_success
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่สามารถเพิ่มสินค้าลงในตะกร้าได้']);
    }
}
?>
