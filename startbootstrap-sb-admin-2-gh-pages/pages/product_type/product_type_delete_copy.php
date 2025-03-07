<?php
require_once('../../../connect/connect.php');

// Check if the product ID is provided in the URL
if (isset($_GET['pty_id'])) {
    $pty_id = $_GET['pty_id'];

    // Fetch product data based on the provided product ID
    $sql_script = "SELECT * FROM product_type WHERE pty_id = $pty_id";
    $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_error($proj_connect));
    $row_result = mysqli_fetch_assoc($result);

    // Check if the form is submitted for deletion
  
        // Perform the product deletion
        $delete_sql = "DELETE FROM product_type WHERE pty_id = $pty_id";
        if (mysqli_query($proj_connect, $delete_sql)) {
            header("Location: ../product_type/"); // Redirect to product list page after successful delete
            exit();
            // You can redirect to another page or take appropriate action here.
        } else {
            echo "Error deleting product: " . mysqli_error($proj_connect);
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
    <p>Product ID: <?php echo $row_result['pty_id']; ?></p>
    <p>Product Name: <?php echo $row_result['pty_name']; ?></p>
    <p>Description: <?php echo $row_result['pty_desc']; ?></p>
    <p>product type show: <?php echo $row_result['pty_show']; ?></p>
    <!-- Add more product details as needed -->

    <form method="POST">
        <input type="submit" name="confirm_delete" value="Confirm Delete">
        <a href="product_type_show.php">ยกเลิก</a>
    </form>
</body>
</html>
