<?php
require_once('../connect.php');

// Function to recursively delete a directory and its contents
function deleteDirectory($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object)) {
                    deleteDirectory($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        rmdir($dir);
    }
}

// Check if the product ID is provided in the URL
if (isset($_GET['prd_id'])) {
    $prd_id = $_GET['prd_id'];

    // Fetch product data based on the provided product ID
    $sql_script = "SELECT * FROM product WHERE prd_id = $prd_id";
    $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_error($proj_connect));
    $row_result = mysqli_fetch_assoc($result);

    $query_pty = "SELECT * FROM product_type ";
    $pty = mysqli_query($proj_connect, $query_pty) or die(mysqli_connect_error());
    $row_pty = mysqli_fetch_assoc($pty);
    $totalrows_pty = mysqli_num_rows($pty);

    // Check if the form is submitted for deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
        // Get the folder name based on the prd_id
        $folderName = "product_img/" . $prd_id;

        // Delete the folder and its contents
        deleteDirectory($folderName);

        // Delete records from the product_img table
        $delete_img_sql = "DELETE FROM product_img WHERE prd_id = $prd_id";

        if (mysqli_query($proj_connect, $delete_img_sql)) {
            // Delete the product data
            $delete_sql = "DELETE FROM product WHERE prd_id = $prd_id";

            if (mysqli_query($proj_connect, $delete_sql)) {
                header("Location: product_show.php"); // Redirect to product list page after successful delete
                exit();
            } else {
                echo "Error deleting product: " . mysqli_error($proj_connect);
            }
        } else {
            echo "Error deleting product images: " . mysqli_error($proj_connect);
        }
    }
} else {
    // Handle the case where prd_id is not provided in the URL
    echo "Product ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
</head>
<body>
    <h1>ลบข้อมูลผลิตภัณฑ์</h1>
    <p>ต้องการลบข้อมูลผลิตภัณฑ์นี้หรือไม่?</p>
    <p>Product ID: <?php echo $row_result['prd_id']; ?></p>
    <p>Product Name: <?php echo $row_result['prd_name']; ?></p>
    <p>Description: <?php echo $row_result['prd_desc']; ?></p>
    <p>Img: <img src="../<?php echo $row_result['prd_img']; ?>" alt=""></p>
    <p>pty name: <?php echo $row_pty['pty_name']; ?></p>
    <!-- Add more product details as needed -->

    <form method="POST">
        <input type="submit" name="confirm_delete" value="Confirm Delete">
        <a href="product_show.php">ยกเลิก</a>
    </form>
</body>
</html>
