<?php
 require('../connectPDO/connnectpdo.php');

try {
    // Prepare a statement to select unread orders
    $stmt = $conn->prepare("SELECT * FROM orders WHERE read_status = 'unread'");
    $stmt->execute();

    // Fetch all the unread notifications
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send a JSON response back to the client
    echo json_encode(['status' => 'success', 'data' => $notifications]);
} catch (PDOException $e) {
    // In case of an error, send an error response
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
