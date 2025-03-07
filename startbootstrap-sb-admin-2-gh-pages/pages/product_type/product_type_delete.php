<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["pty_id"])) {
    require_once('../../../connect/connect.php');
    $pty_id = $_GET["pty_id"];
    
    if (!is_numeric($pty_id)) {
        echo json_encode(['success' => false, 'message' => 'รหัสประเภทสินค้าไม่ถูกต้อง']);
        exit;
    }

    // เพิ่มเงื่อนไขตรวจสอบว่ามีสินค้าในประเภทนี้หรือไม่
    $checkProductSql = "SELECT COUNT(*) as productCount FROM product WHERE pty_id = $pty_id";
    $result = $proj_connect->query($checkProductSql);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $productCount = $row["productCount"];
        
        if ($productCount > 0) {
            echo json_encode(['success' => false, 'message' => 'ไม่สามารถลบประเภทสินค้าที่มีสินค้าอยู่ได้']);
            exit;
        }
    }

    $deleteSql = "DELETE FROM product_type WHERE pty_id = $pty_id";

    if ($proj_connect->query($deleteSql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'ลบข้อมูลประเภทสินค้าสำเร็จ']);
    } else {
        echo json_encode(['success' => false, 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . $proj_connect->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ร้องขอไม่ถูกต้อง']);
}

?>
