<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
require_once('../../connect/connect.php');

// Check if the image ID and prd_id are provided in the query string
if (isset($_GET['img_id']) && isset($_GET['prd_id'])) {
    $img_id = $_GET['img_id'];
    $prd_id = $_GET['prd_id']; // Get the prd_id from the query string

    // Get the image path from the database
    $query_image_path = "SELECT img FROM product_img WHERE img_id = '$img_id'";
    $result_image_path = $proj_connect->query($query_image_path);

    if ($result_image_path->num_rows > 0) {
        $row_image_path = $result_image_path->fetch_assoc();
        $img_path = $row_image_path['img'];

        // Delete the image file from the server
        if (file_exists($img_path)) {
            unlink($img_path);
            // Redirect back to the edit page with the prd_id
            $delete_success = true;
        }

        // Delete the image record from the database
        $delete_query = "DELETE FROM product_img WHERE img_id = '$img_id'";
        if ($proj_connect->query($delete_query) === TRUE) {
            // Redirect back to the edit page with the prd_id
            $delete_success = true;
        } else {
            echo "Error deleting image: " . $proj_connect->error;
        }
    } else {
        echo "Image not found.";
    }
} else {
    echo "Image ID or prd_id not provided.";
}
?>
 <?php if (isset($delete_success) && $delete_success) : ?>
    <script>
            Swal.fire({
                icon: "success",
                title: "สำเร็จ!",
                text: "ลบรูปภาพเรียบร้อย",
                showConfirmButton: false,
                timer: 800
            }).then(function() {
                window.location.href = "product_edit.php?prd_id=<?php echo $prd_id?>";
            });
        </script>
    <?php endif; ?>
</body>
</html>
