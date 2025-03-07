<?php
// Start or resume a session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection script
    require 'connect.php'; // Adjust the path as needed

    // Get the form data
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $mmb_id = $_SESSION['mmb_id'] ?? ''; // Assuming you store user ID in session

    // Initial response array
    $response = [
        'success' => false,
        'message' => 'An error occurred.'
    ];

    // Validate form data
    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $response['message'] = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $response['message'] = 'New passwords do not match.';
    } else {
        // Fetch the current password from the database
        $query = "SELECT mmb_pwd FROM member WHERE mmb_id = ?";
        $stmt = $proj_connect->prepare($query);
        $stmt->bind_param('i', $mmb_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the old password
        if ($stmt->num_rows == 1 && password_verify($old_password, $hashed_password)) {
            // Old password is correct; update with the new password
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE member SET mmb_pwd = ? WHERE mmb_id = ?";
            $updateStmt = $proj_connect->prepare($updateQuery);
            $updateStmt->bind_param('si', $new_hashed_password, $mmb_id);
            if ($updateStmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Password updated successfully.';
            } else {
                $response['message'] = 'Failed to update the password.';
            }
            $updateStmt->close();
        } else {
            $response['message'] = 'Old password is incorrect.';
        }
        $stmt->close();
    }

    // Close the database connection
    $proj_connect->close();

    // Return the JSON response
    echo json_encode($response);
} else {
    // Not a POST request

}
?>
