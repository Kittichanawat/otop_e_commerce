<?php
// Assuming you have a $conn object (PDO connection) established
// Assuming you have a $conn object (PDO connection) established
require_once('../connectPDO/connnectpdo.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prd_id']) && isset($_POST['prd_show'])) {
    $prd_id = $_POST['prd_id'];
    $prd_show = $_POST['prd_show'];

    try {
        $stmt = $conn->prepare("UPDATE product SET prd_show = :prd_show WHERE prd_id = :prd_id");
        $stmt->bindParam(':prd_show', $prd_show, PDO::PARAM_INT);
        $stmt->bindParam(':prd_id', $prd_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Update successful";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>