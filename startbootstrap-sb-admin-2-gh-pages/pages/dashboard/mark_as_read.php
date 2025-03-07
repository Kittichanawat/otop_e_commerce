<?php
 require('../connectPDO/connnectpdo.php');// Database connection file

// Check if order_id is provided
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Prepare SQL statement to update read_status to 'read'
    $stmt = $conn->prepare("UPDATE orders SET read_status = 'read' WHERE order_id = :order_id");
    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        // If successful, send a JSON response back to the client
        echo json_encode(['status' => 'success', 'message' => 'Notification marked as read']);
    } catch (PDOException $e) {
        // In case of error, send an error response
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    // If order_id is not provided, send a bad request response
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Order ID is required']);
}
?>
