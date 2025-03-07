<?php
require_once('connect.php');

// Check if the product ID is provided in the URL
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

    // Fetch product data based on the provided product ID
    $sql_script = "SELECT * FROM tourist WHERE p_id = $p_id";
    $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_error($proj_connect));
    $row_result = mysqli_fetch_assoc($result);
   
 

    // Check if the form is submitted for deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
        // เก็บชื่อไฟล์รูปภาพ
        $imageFilePath = $row_result['p_img'];
        
        // ลบข้อมูลสินค้า
        $delete_sql = "DELETE FROM tourist WHERE p_id = $p_id";
        
        if (mysqli_query($proj_connect, $delete_sql)) {
            // ลบไฟล์รูปภาพจากโฟลเดอร์ uploads
            if (file_exists($imageFilePath)) {
                unlink($imageFilePath);
            }
            
            header("Location: tourist_show.php"); // Redirect to product list page after successful delete
            exit();
            // You can redirect to another page or take appropriate action here.
        } else {
            echo "Error deleting product: " . mysqli_error($proj_connect);
        }
    }
} else {
    // Handle the case where p_id is not provided in the URL
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
    <p>Product ID: <?php echo $row_result['p_id']; ?></p>
    <p>Product Name: <?php echo $row_result['p_name']; ?></p>
    <p>Description: <?php echo $row_result['p_des']; ?></p>
    <p>Img: <img src="<?php echo $row_result['p_img']; ?>" alt="" width="200" height="200"></p>

  
    <!-- Add more product details as needed -->

    <form method="POST">
        <input type="submit" name="confirm_delete" value="Confirm Delete">
        <a href="tourist_show.php">ยกเลิก</a>
    </form>
</body>
</html>
