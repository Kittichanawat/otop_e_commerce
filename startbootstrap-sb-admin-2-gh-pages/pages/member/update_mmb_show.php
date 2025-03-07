<?php
// Assuming you have a $conn object (PDO connection) established
require_once('../connectPDO/connnectpdo.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mmb_id']) && isset($_POST['mmb_show'])) {
    $mmb_id = $_POST['mmb_id'];
    $mmb_show = $_POST['mmb_show'];

    try {
        $stmt = $conn->prepare("UPDATE member SET mmb_show = :mmb_show WHERE mmb_id = :mmb_id");
        $stmt->bindParam(':mmb_show', $mmb_show, PDO::PARAM_INT);
        $stmt->bindParam(':mmb_id', $mmb_id, PDO::PARAM_INT);
        $stmt->execute();

        echo "Update successful";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request";
}
?>