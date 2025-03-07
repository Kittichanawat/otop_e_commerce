<?php
session_start();
require_once('LineLogin.php');
require_once('connect.php');

if (!isset($_SESSION['line_profile'])) {
    header("location: index.php");
} 

// Assuming you have obtained the Line user's information
$lineUsername = $_SESSION['line_profile']->name;

// Fetch user information from the line_member table
$selectQuery = "SELECT * FROM member WHERE mmb_username = '$lineUsername'";
$result = mysqli_query($proj_connect, $selectQuery);

// Check if a record exists
if (mysqli_num_rows($result) > 0) {
    $lineMemberData = mysqli_fetch_assoc($result);
    // You can access individual fields like $lineMemberData['email'], $lineMemberData['other_field'], etc.
} else {
    // Handle the case where the record does not exist
    echo "No data found for the Line user.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Line Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

    <?php require_once("nav.php"); ?>    

    <main class="container">
        <div class="bg-light p-5 rounded">
            <?php 
                if (isset($_SESSION['line_profile'])) {
                    $profile = $_SESSION['line_profile'];
            ?>
            <h1>Welcome, <?php echo $profile->name; ?></h1>
            <p class="lead">Your email: <?php echo $profile->email; ?></p>
            <img src="<?php echo $profile->picture; ?>" class="rounded" alt="profile img">
            <?php
                // Display additional information from line_member table if available
                if (isset($lineMemberData)) {
                    echo "<p>Additional information from line_member table:</p>";
                    echo "<p>Username: " . $lineMemberData['mmb_username'] . "</p>";
                    echo "<p>Email: " . $lineMemberData['mmb_email'] . "</p>";
                    // Display other fields as needed
                }
            ?>
            <?php } ?>
        </div>
    </main>

</body>
</html>
