
<?php
require_once('../../../connect/connect.php');

header('Content-Type: application/json'); // Set the response content type to JSON

$response = array(); // Create an empty response array

// Check if the prd_id is provided in the query string
if (isset($_GET['h_id'])) {
    $h_id = $_GET['h_id']; // Get the prd_id from the query string

    // Update the prd_img field to NULL
    $update_query = "UPDATE history SET h_img = NULL WHERE h_id = '$h_id'";
    
    if ($proj_connect->query($update_query) === TRUE) {
        // Image deletion was successful
        $response['success'] = true;
    } else {
        // Image deletion failed
        $response['success'] = false;
        $response['error'] = "Error updating image: " . $proj_connect->error;
    }
} else {
    // prd_id not provided
    $response['success'] = false;
    $response['error'] = 'prd_id not provided.';
}

// Return the JSON response
echo json_encode($response);
?>

