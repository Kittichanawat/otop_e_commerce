<?php
include '../connectPDO/connnectpdo.php'; // ตรวจสอบชื่อไฟล์ให้ถูกต้อง

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (is_array($data) && isset($data['updates'])) {
    foreach ($data['updates'] as $update) {
        $id = $update['id'];
        $newOrder = $update['newOrder'];

        $sql = "UPDATE banking SET order_column = :newOrder WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newOrder', $newOrder, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Update successful']);
} else {
    echo json_encode(['message' => 'Invalid data format']);
}
?>
