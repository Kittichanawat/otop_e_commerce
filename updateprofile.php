<?php
session_start();
require('connect.php'); // Make sure this path is correct

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $mmb_id = $_SESSION['mmb_id']; // Assuming the user's ID is stored in session
    $mmb_name = $_POST['mmb_name'];
    $mmb_surname = $_POST['mmb_surname'];
    $mmb_addr = $_POST['mmb_addr'];
    $mmb_email = $_POST['mmb_email'];
    $mmb_phone = $_POST['mmb_phone'];

    // Update user details
    $updateQuery = "UPDATE member SET mmb_name = ?, mmb_surname = ?, mmb_addr = ?, mmb_email = ?, mmb_phone = ? WHERE mmb_id = ?";
    $updateStmt = $proj_connect->prepare($updateQuery);
    $updateStmt->bind_param("sssssi", $mmb_name, $mmb_surname, $mmb_addr, $mmb_email, $mmb_phone, $mmb_id);

    if ($updateStmt->execute()) {
        // If update is successful
        echo json_encode(array("success" => true, "message" => "Profile updated successfully."));
    } else {
        // If update failed
        echo json_encode(array("success" => false, "message" => "Failed to update profile."));
    }
    $updateStmt->close();
} else {
    // If form is not submitted
    echo json_encode(array("success" => false, "message" => "Form not submitted."));
}

$proj_connect->close();
?>
