<?php
require('connect/connect.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the JSON data from the request body
    $json_data = file_get_contents("php://input");
    
    // Check if JSON data was received
    if ($json_data) {
        // Decode the JSON data into an associative array
        $order_data = json_decode($json_data, true);

        if (is_array($order_data)) {
            // Extract order data
            $mmb_id = $order_data['mmb_id'];
            $prd_id = $order_data['prd_id'];
            $crt_amount = $order_data['crt_amount'];
            $order_status = $order_data['order_status'];
            $crt_id = $order_data['crt_id'];
            $mmb_addr = $order_data['mmb_addr'];
            $mmb_email = $order_data['mmb_email'];
            $mmb_phone = $order_data['mmb_phone'];

            // Insert or update the order in the database
            $sql = "INSERT INTO orders (mmb_id, prd_id, crt_amount, order_status, crt_id, mmb_addr, mmb_email, mmb_phone) 
                    VALUES ('$mmb_id', '$prd_id', '$crt_amount', '$order_status', '$crt_id', '$mmb_addr', '$mmb_email', '$mmb_phone')";

            if (mysqli_query($proj_connect, $sql)) {
                // Order was successfully inserted or updated
                $response = array('success' => true, 'message' => 'Order updated successfully');
            } else {
                // Error occurred
                $response = array('success' => false, 'message' => 'Error updating order: ' . mysqli_error($proj_connect));
            }
        } else {
            $response = array('success' => false, 'message' => 'Invalid JSON data');
        }
    } else {
        $response = array('success' => false, 'message' => 'No JSON data received');
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request method');
}

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($proj_connect);
?>
