
<?php
require_once('../../../connect/connect.php');

header('Content-Type: application/json'); // Set the response content type to JSON

$response = array(); // Create an empty response array

// Check if the t_id is provided in the query string
if (isset($_GET['t_id'])) {
    $t_id = $_GET['t_id']; // Get the t_id from the query string

    // Update the prd_img field to NULL
    $update_query = "UPDATE tradition SET t_img = NULL WHERE t_id = '$t_id'";
    
    if ($proj_connect->query($update_query) === TRUE) {
        // Image deletion was successful
        $response['success'] = true;
    } else {
        // Image deletion failed
        $response['success'] = false;
        $response['error'] = "Error updating image: " . $proj_connect->error;
    }
} else {
    // t_id not provided
    $response['success'] = false;
    $response['error'] = 't_id not provided.';
}

// Return the JSON response
echo json_encode($response);
?>

