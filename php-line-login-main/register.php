<?php
session_start();
header('Content-Type: application/json');


require_once('../connect.php'); // Adjust the path as needed

$response = ['success' => false, 'errorMessage' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data with basic validation (sanitize inputs in real application)
    $mmb_name = $_POST['mmb_name'] ?? '';
    $mmb_surname = $_POST['mmb_surname'] ?? '';
    $mmb_username = $_POST['mmb_username'] ?? '';
    $mmb_pwd = $_POST['mmb_pwd'] ?? '';
    $mmb_confirm_pwd = $_POST['mmb_confirm_pwd'] ?? '';
    $mmb_addr = $_POST['mmb_addr'] ?? '';
    $mmb_email = $_POST['mmb_email'] ?? '';
    $mmb_phone = $_POST['mmb_phone'] ?? '';

    // Check for duplicate usernames
    $stmt = $proj_connect->prepare("SELECT mmb_id FROM member WHERE mmb_username = ?");
    $stmt->bind_param("s", $mmb_username);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $response['errorMessage'] = 'ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว';
    } elseif ($mmb_pwd !== $mmb_confirm_pwd) {
        $response['errorMessage'] = 'รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน';
    } else {
        // Password validation: Ensure it's strong enough (implement your own criteria)
        if (strlen($mmb_pwd) < 6) {
            $response['errorMessage'] = 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร';
        } else {
            // Hash password
            $password_hash = password_hash($mmb_pwd, PASSWORD_DEFAULT);

            // Insert new member
            $insert_stmt = $proj_connect->prepare("INSERT INTO member (mmb_name, mmb_surname, mmb_username, mmb_pwd, mmb_addr, mmb_email, mmb_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("sssssss", $mmb_name, $mmb_surname, $mmb_username, $password_hash, $mmb_addr, $mmb_email, $mmb_phone);

            if ($insert_stmt->execute()) {
                // Get the last inserted ID to use for role assignment
                $last_id = $proj_connect->insert_id;

                // Assign default roles
                $default_member = 1; // Member role is set by default
                $default_admin = 0;
                $default_superadmin = 0;
                $level_stmt = $proj_connect->prepare("INSERT INTO member_levels (mmb_id, member, admin, superadmin) VALUES (?, ?, ?, ?)");
                $level_stmt->bind_param("iiii", $last_id, $default_member, $default_admin, $default_superadmin);
                
                if ($level_stmt->execute()) {
                    $response['success'] = true;
                } else {
                    $response['errorMessage'] = 'Error adding member level';
                }

                $level_stmt->close();
            } else {
                $response['errorMessage'] = 'Error adding member';
            }

            $insert_stmt->close();
        }
    }
    $stmt->close();
} else {
    $response['errorMessage'] = 'Invalid request method';
}

echo json_encode($response);
?>
