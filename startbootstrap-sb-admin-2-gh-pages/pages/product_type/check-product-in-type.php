<?php
require_once('../../../connect/connect.php');

if (isset($_POST['pty_id'])) {
    $pty_id = $_POST['pty_id'];

    $query = "SELECT COUNT(*) as product_count FROM product WHERE pty_id = ?";
    if ($stmt = $proj_connect->prepare($query)) {
        $stmt->bind_param("i", $pty_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo $row['product_count'];
    } else {
        echo "0"; // หากเกิดข้อผิดพลาด
    }
} else {
    echo "0"; // หากไม่มี pty_id ถูกส่งมา
}
?>
