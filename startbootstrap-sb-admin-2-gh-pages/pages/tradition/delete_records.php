<?php
require('../connectPDO/connnectpdo.php');

// Read the JSON data from the request body
$jsonData = file_get_contents("php://input");

if ($jsonData) {
    $requestData = json_decode($jsonData, true);

    if ($requestData && isset($requestData['tIds']) && is_array($requestData['tIds'])) {
        $deleteIDs = implode(',', $requestData['tIds']); // Get the IDs of selected records as a comma-separated string.
        $sql = "DELETE FROM tradition WHERE t_id IN ($deleteIDs)";

        if ($conn->exec($sql)) {
            echo json_encode(['success' => true, 'message' => 'Records deleted successfully']);
            // You can also return additional data if needed.
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting records: ' . print_r($conn->errorInfo())]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing data in the JSON request.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No data received in the request.']);
}
?>
