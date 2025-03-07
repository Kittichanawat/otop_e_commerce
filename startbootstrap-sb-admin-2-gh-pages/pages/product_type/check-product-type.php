<?php
require_once('../../../connect/connect.php'); // เปลี่ยนเส้นทางตามที่ตั้งของไฟล์ connect.php ของคุณ

if (isset($_POST['pty_name'])) {
    $pty_name = $_POST['pty_name'];

    // สร้างคำสั่ง SQL เพื่อตรวจสอบชื่อประเภทผลิตภัณฑ์
    $query = "SELECT COUNT(*) FROM product_type WHERE pty_name = ?";
    
    // เตรียมคำสั่ง SQL
    if ($stmt = $proj_connect->prepare($query)) {
        // ผูกพารามิเตอร์
        $stmt->bind_param("s", $pty_name);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ผูกผลลัพธ์
        $stmt->bind_result($count);

        // ดึงผลลัพธ์
        $stmt->fetch();

        // ปิด statement
        $stmt->close();

        // ตรวจสอบว่าพบชื่อประเภทหรือไม่
        if ($count > 0) {
            // ชื่อประเภทมีอยู่แล้วในฐานข้อมูล
            echo "false";
        } else {
            // ชื่อประเภทยังไม่มีในฐานข้อมูล
            echo "true";
        }
    } else {
        echo "Error: Could not prepare the SQL statement.";
    }
} else {
    echo "No product type name provided.";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$proj_connect->close();
?>
