<?php
session_start();
require_once('LineLogin.php');
require_once('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../mainweb_page/head.php'); ?>
<body>

<?php
$line = new LineLogin();
$get = $_GET;

$code = $get['code'];
$state = $get['state'];
$token = $line->token($code, $state);

if (property_exists($token, 'error')) {
    header('location: index.php');
} else if ($token->id_token) {
    $profile = $line->profileFormIdToken($token);

    // Check if the 'id' property exists in the $profile object
    $lineUserId = property_exists($profile, 'id') ? $profile->id : null;
    $lineUsername = $profile->name;
    $lineEmail = $profile->email;

    // Check if the user already exists in the member table
    $checkUserQuery = "SELECT * FROM member WHERE mmb_username = '$lineUsername'";
    $checkUserResult = mysqli_query($proj_connect, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) == 0) {
        // User does not exist, insert a new record with available data
        $insertQuery = "INSERT INTO member (mmb_username, mmb_email) VALUES ('$lineUsername', '$lineEmail')";
        
        // Execute the query
        $insertResult = mysqli_query($proj_connect, $insertQuery);

        if (!$insertResult) {
            die("Error inserting data into member: " . mysqli_error($proj_connect));
        }
    }

    // Fetch the user data from the member table
    $getUserQuery = "SELECT * FROM member WHERE mmb_username = '$lineUsername'";
    $getUserResult = mysqli_query($proj_connect, $getUserQuery);

    if ($getUserResult && mysqli_num_rows($getUserResult) > 0) {
        $userData = mysqli_fetch_assoc($getUserResult);

        // Store Line user and member information in the session
        $_SESSION['mmb_username'] = $userData['mmb_username'];
        $_SESSION['mmb_id'] = $userData['mmb_id'];

        // Check and set member levels
        $level_id = null;
        if ($userData['mmb_id']) {
            $level_id = $userData['mmb_id'];

            // Check if the user already has a level record in member_levels table
            $checkLevelQuery = "SELECT * FROM member_levels WHERE mmb_id = '$level_id'";
            $checkLevelResult = mysqli_query($proj_connect, $checkLevelQuery);

            if (mysqli_num_rows($checkLevelResult) == 0) {
                // User does not have a level record, insert a new record
                $insertLevelQuery = "INSERT INTO member_levels (member, mmb_id) VALUES (1, '$level_id')";
                $insertLevelResult = mysqli_query($proj_connect, $insertLevelQuery);

                if (!$insertLevelResult) {
                    die("Error inserting data into member_levels: " . mysqli_error($proj_connect));
                }
            }
        }

        // Fetch the user's level data from the member_levels table
        $getLevelQuery = "SELECT * FROM member_levels WHERE mmb_id = '$level_id'";
        $getLevelResult = mysqli_query($proj_connect, $getLevelQuery);

        if ($getLevelResult && mysqli_num_rows($getLevelResult) > 0) {
            $levelData = mysqli_fetch_assoc($getLevelResult);

            // Store member levels in the session
            $_SESSION['member'] = $levelData['member'];
            $_SESSION['admin'] = $levelData['admin'];
            $_SESSION['superadmin'] = $levelData['superadmin'];
        }

        // SweetAlert notification after successful login
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "เข้าสู่ระบบสำเร็จ!!",
                    text: "ยินดีต้อนรับ, ' . $profile->name . '!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "../index.php"; // Redirect after the alert is closed
                });
              </script>';
    } else {
        header('location: index.php');
    }
} else {
    header('location: index.php');
}
?>

</body>
</html>
