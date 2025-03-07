<?php
// ตัวอย่างเท่านั้น ต้องปรับให้ตรงกับโครงสร้างของฐานข้อมูลของคุณ

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["mmb_username"])) {
    // ตรวจสอบว่าชื่อผู้ใช้ซ้ำหรือไม่
    $username = $_POST["mmb_username"];

    // ปรับเปลี่ยนข้อมูลการเชื่อมต่อฐานข้อมูลตามความเหมาะสม
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "otop";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM member WHERE mmb_username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ถ้าซ้ำ
        echo json_encode(false);
    } else {
        // ถ้าไม่ซ้ำ
        echo json_encode(true);
    }

    $stmt->close();
    $conn->close();
} else {
    // ไม่ได้รับข้อมูลที่ต้องการ
    echo json_encode(false);
}
?>
