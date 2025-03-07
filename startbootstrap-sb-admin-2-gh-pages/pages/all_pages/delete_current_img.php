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
require_once('../../../connect/connect.php');

// Check if the image ID and id are provided in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the id from the query string

    // Update the img field to NULL
    $update_query = "UPDATE page SET img = NULL WHERE id = '$id'";
    if ($proj_connect->query($update_query) === TRUE) {
        // Redirect back to the edit page with the id
        $delete_success = true;
     
    } else {
        echo "Error updating image: " . $proj_connect->error;
    }
} else {
    echo "id not provided.";
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
                window.location.href = "pages_edit.php?id=<?php echo $id?>";
            });
        </script>
    <?php endif; ?>
</body>
</html>
