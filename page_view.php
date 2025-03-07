<?php
// เชื่อมต่อฐานข้อมูล
$mysqli = new mysqli("localhost", "root", "", "otop");

// ตรวจสอบการเชื่อมต่อ
if ($mysqli->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $mysqli->connect_error);
}

// หาชื่อของหน้าเว็บปัจจุบัน
$page_name = $_SERVER['REQUEST_URI'];

// ค้นหาหน้าเว็บในฐานข้อมูล
$result = $mysqli->query("SELECT * FROM page_views WHERE page_name = '$page_name'");

if ($result->num_rows > 0) {
    // หากหน้าเว็บมีอยู่แล้วในฐานข้อมูล
    $row = $result->fetch_assoc();
    $view_count = $row['view_count'] + 1;

    // อัปเดตจำนวนการเข้าชม
    $mysqli->query("UPDATE page_views SET view_count = '$view_count' WHERE page_name = '$page_name'");
} else {
    // หากหน้าเว็บยังไม่มีในฐานข้อมูล
    $mysqli->query("INSERT INTO page_views (page_name, view_count) VALUES ('$page_name', 1)");
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$mysqli->close();
?>