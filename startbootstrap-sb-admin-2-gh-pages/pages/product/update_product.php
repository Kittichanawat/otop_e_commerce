<?php
require_once('../../../connect/connect.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the product ID, column, and checked value from the POST data
    $prdId = $_POST['prdId'];
    $column = $_POST['column'];
    $checked = $_POST['checked'];

    // Validate the column name to prevent SQL injection
    if ($column !== 'prd_show' && $column !== 'prd_reccom') {
        echo 'Invalid column name';
        exit;
    }

    // Update the product record in the database
    $updateSql = "UPDATE product SET $column = $checked WHERE prd_id = $prdId";

    if (mysqli_query($proj_connect, $updateSql)) {
        echo 'บันทึกสำเร็จ';
    } else {
        echo 'เกิดข้อผิดพลาดในการบันทึก: ' . mysqli_error($proj_connect);
    }
} else {
    echo 'Invalid request';
}
?>
