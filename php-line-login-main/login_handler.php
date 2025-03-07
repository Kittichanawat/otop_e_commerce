<?php
session_start();
header('Content-Type: application/json');

require_once('../connect.php'); // Adjust the path as needed

$response = ['success' => false, 'redirectURL' => '', 'errorMessage' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mmb_username = $_POST["mmb_username"] ?? '';
    $mmb_pwd = $_POST["mmb_pwd"] ?? '';

    if (empty($mmb_username) || empty($mmb_pwd)) {
        $response['errorMessage'] = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
    } else {
        // Fetch user details from `member` table
        $query = "SELECT * FROM member WHERE mmb_username = ?";
        $stmt = mysqli_prepare($proj_connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $mmb_username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($mmb_pwd, $row['mmb_pwd'])) {
                    if ($row['mmb_show'] == 0) {
                        $response['errorMessage'] = "บัญชีผู้ใช้ของคุณถูกระงับชั่วคราว กรุณาติดต่อผู้ดูแลระบบ";
                    } else {
                        $_SESSION['mmb_id'] = $row['mmb_id'];
                        $_SESSION['mmb_username'] = $row['mmb_username'];
                        $_SESSION['mmb_name'] = $row['mmb_name'];
                        $_SESSION['mmb_surname'] = $row['mmb_surname'];

                        // New query to fetch roles from `member_levels`
                        $levels_query = "SELECT admin, superadmin FROM member_levels WHERE mmb_id = ?";
                        $levels_stmt = mysqli_prepare($proj_connect, $levels_query);
                        if ($levels_stmt) {
                            mysqli_stmt_bind_param($levels_stmt, "s", $row['mmb_id']); // Ensure mmb_id is of the correct type
                            mysqli_stmt_execute($levels_stmt);
                            $levels_result = mysqli_stmt_get_result($levels_stmt);

                            $isAdmin = $isSuperAdmin = false; // Default values
                            if ($levels_row = mysqli_fetch_assoc($levels_result)) {
                                $isAdmin = (bool)$levels_row['admin'];
                                $isSuperAdmin = (bool)$levels_row['superadmin'];
                            }
                            mysqli_stmt_close($levels_stmt);

                            // Set session variables for roles
                            $_SESSION['admin'] = $isAdmin;
                            $_SESSION['superadmin'] = $isSuperAdmin;

                            // Redirect based on user role
                            $redirectURL = 'index.php'; // Default redirect for regular users
                            if ($isAdmin || $isSuperAdmin) {
                                $redirectURL = 'startbootstrap-sb-admin-2-gh-pages/pages/dashboard/'; // Admins and superadmins get redirected to the dashboard
                            }

                            $response['success'] = true;
                            $response['redirectURL'] = $redirectURL;
                        }
                    }
                } else {
                    $response['errorMessage'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
                }
            } else {
                $response['errorMessage'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            }
            mysqli_stmt_close($stmt);
        } else {
            $response['errorMessage'] = "เกิดข้อผิดพลาดในการเข้าสู่ระบบ";
        }
    }
} else {
    $response['errorMessage'] = "Invalid request method.";
}

echo json_encode($response);
?>
