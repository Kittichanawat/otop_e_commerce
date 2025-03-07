<?php
require_once('../../../connect/connect.php');
session_start();

// Check if the user is logged in

// Get the user's status from the session
$userStatus = $_SESSION['status'];

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["mmb_id"])) {
    $mmb_id = $_GET["mmb_id"];

    // Check if the logged-in user is attempting to delete themselves
    if ($mmb_id == $_SESSION['mmb_id']) {
        header('Location: ../member/');
        exit;
    }

    // Check the user's status and apply the appropriate conditions
    if ($userStatus == 'superadmin') {
        // Superadmin can delete admin and member but not other superadmins
        $query = "SELECT * FROM member WHERE mmb_id = $mmb_id";
        $result = mysqli_query($proj_connect, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['status'] != 'superadmin') {
                $delete_query = "DELETE FROM member WHERE mmb_id = $mmb_id";
                if (mysqli_query($proj_connect, $delete_query)) {
                    // Member deleted successfully, return a JSON response
                    echo json_encode(array("success" => true));
                } else {
                    // Error occurred during deletion
                    echo json_encode(array("success" => false, "message" => "Error deleting member: " . mysqli_error($proj_connect)));
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Superadmins cannot be deleted."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Member not found."));
        }
    } elseif ($userStatus == 'admin') {
        // Admin can only delete members, not other admins or superadmins
        $query = "SELECT status FROM member WHERE mmb_id = $mmb_id";
        $result = mysqli_query($proj_connect, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['status'] != 'admin' && $row['status'] != 'superadmin') {
                $delete_query = "DELETE FROM member WHERE mmb_id = $mmb_id";
                if (mysqli_query($proj_connect, $delete_query)) {
                    // Member deleted successfully, return a JSON response
                    echo json_encode(array("success" => true));
                } else {
                    // Error occurred during deletion
                    echo json_encode(array("success" => false, "message" => "Error deleting member: " . mysqli_error($proj_connect)));
                }
            } else {
                echo json_encode(array("success" => false, "message" => "Admins cannot delete other admins or superadmins."));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Member not found."));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "You do not have permission to delete members."));
    }
}
?>
