<?php
require_once('../../../connect/connect.php');

// Create an associative array to hold the response data
$response = array();

// Check if the image ID and prd_id are provided in the query string
if (isset($_GET['img_id']) && isset($_GET['prd_id'])) {
    $img_id = $_GET['img_id'];
    $prd_id = $_GET['prd_id']; // Get the prd_id from the query string

    // Get the image path from the database
    $query_image_path = "SELECT img FROM product_img WHERE img_id = '$img_id'";
    $result_image_path = $proj_connect->query($query_image_path);

    if ($result_image_path->num_rows > 0) {
        $row_image_path = $result_image_path->fetch_assoc();
        $img_path = $row_image_path['img'];

        // Delete the image file from the server
        if (file_exists($img_path)) {
            unlink($img_path);
            // Set the success status in the response
            $response['success'] = true;
        }

        // Delete the image record from the database
        $delete_query = "DELETE FROM product_img WHERE img_id = '$img_id'";
        if ($proj_connect->query($delete_query) === TRUE) {
            // Set the success status in the response
            $response['success'] = true;
        } else {
            // Set an error message in the response
            $response['success'] = false;
            $response['message'] = "Error deleting image: " . $proj_connect->error;
        }
    } else {
        // Set an error message in the response
        $response['success'] = false;
        $response['message'] = "Image not found.";
    }
} else {
    // Set an error message in the response
    $response['success'] = false;
    $response['message'] = "Image ID or prd_id not provided.";
}

// Convert the response array to a JSON string and send it
header('Content-Type: application/json');
echo json_encode($response);
?>
