<?php
require_once('../../connect/connect.php');

// ตรวจสอบว่าผู้ใช้มีค่า session admin ไม่เท่ากับหนึ่ง


// Check if the product ID is provided in the query string
if (isset($_GET['prd_id'])) {
    $prd_id = $_GET['prd_id'];

    // Search for product data in the database
    $sql = "SELECT * FROM product WHERE prd_id = '$prd_id'";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $prd_name = $row['prd_name'];
        $prd_desc = $row['prd_desc'];
        $prd_price = $row['prd_price'];
        $pty_id = $row['pty_id'];
        $prd_show = $row['prd_show'];
        $prd_reccom = $row['prd_reccom'];
        $prd_img = $row['prd_img'];
    } else {
        // If the product to edit is not found in the database
        echo "ไม่พบสินค้าที่ต้องการแก้ไข";
        exit;
    }
} else {
    // If the product ID is not provided in the query string
    echo "ไม่ระบุรหัสสินค้าที่ต้องการแก้ไข";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receive data from the form
    $new_prd_name = $_POST["prd_name"];
    $new_prd_desc = $_POST["prd_desc"];
    $new_prd_price = $_POST["prd_price"];
    $new_pty_id = $_POST["pty_id"];
    $new_prd_show = $_POST["prd_show"];
    $new_prd_reccom = $_POST["prd_reccom"];

    // Check if a new image file is selected
    if ($_FILES["new_image"]["name"]) {
        // Receive the new image file
        $new_image = $_FILES["new_image"];
        $targetDirectory = "uploads/"; // Create an "uploads" directory to store new images
        $targetFile = $targetDirectory . basename($new_image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($new_image["tmp_name"]);
        if ($check === false) {
            echo "ไฟล์ไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }

        // Check the file size (you can adjust the limit as needed)
        if ($new_image["size"] > 500000) {
            echo "ขออภัย, ไฟล์มีขนาดใหญ่เกินไป.";
            $uploadOk = 0;
        }

        // Allow only specific image file types (you can modify the list)
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "ขออภัย, ไม่สามารถอัพโหลดไฟล์ได้.";
        } else {
            // If everything is valid, delete the old image file (if exists) and upload the new one
            if (move_uploaded_file($new_image["tmp_name"], $targetFile)) {
                echo "ไฟล์ " . htmlspecialchars(basename($new_image["name"])) . " อัพโหลดเรียบร้อย.";

                // Delete the old image file (if it exists)
                if (file_exists($prd_img)) {
                    unlink($prd_img);
                }

                // Update the data in the database
                $update_sql = "UPDATE product SET prd_name = '$new_prd_name', prd_desc = '$new_prd_desc',prd_price = '$new_prd_price', prd_img = '$targetFile', pty_id = '$new_pty_id', prd_show = '$new_prd_show', prd_reccom  = '$new_prd_reccom' WHERE prd_id = '$prd_id'";
                if ($proj_connect->query($update_sql) === TRUE) {
                    header("Location: product_show.php");
                } else {
                    echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
                }
            } else {
                echo "ข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        }
    } else {
        // If no new image file is selected
        // Update the data in the database without changing the image
        $update_sql = "UPDATE product SET prd_name = '$new_prd_name', prd_desc = '$new_prd_desc',prd_price = '$new_prd_price', pty_id = '$new_pty_id', prd_show = '$new_prd_show', prd_reccom  = '$new_prd_reccom' WHERE prd_id = '$prd_id'";
        if ($proj_connect->query($update_sql) === TRUE) {
            header("Location: product_show.php");
        } else {
            echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
        }
    }

    // Handle additional images
    if (!empty($_FILES["additional_images"]["name"][0])) {
        $productImgDirectory = "product_img/$prd_id/";

        if (!file_exists($productImgDirectory)) {
            mkdir($productImgDirectory, 0777, true);
        }

        foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
            $img_name = $_FILES["additional_images"]["name"][$key];
            $img_tmp_name = $_FILES["additional_images"]["tmp_name"][$key];
            $img_target = $productImgDirectory . basename($img_name);

            if (move_uploaded_file($img_tmp_name, $img_target)) {
                // Insert image paths into the product_img table
                $sql = "INSERT INTO product_img (prd_id, img, img_show) VALUES ('$prd_id', '$img_target', '1')";

                if ($proj_connect->query($sql) !== TRUE) {
                    echo "ข้อผิดพลาดในการบันทึกข้อมูลรูปภาพ: " . $proj_connect->error;
                }
            } else {
                echo "ข้อผิดพลาดในการอัพโหลดรูปภาพ: " . $img_name;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Buttons</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <style>
        /* Container for the image and delete link */
        .image-container {
            position: relative;
            display: inline-block;
        }

        /* The image */
        .image-container img {
            max-width: 300px;
            max-height: 300px;
        }

        /* The delete link */
        .delete-link {
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            cursor: pointer;
        }

        .delete-button {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
        }

        .image-container {
            display: inline-block;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
      <?php include('../web_stuc/side_bar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">
        <h2>แก้ไขสินค้า</h2>
        <form action="" method="post" enctype="multipart/form-data" onSubmit="return(chkdata(this));">
            <div class="mb-3">
                <label for="prd_name" class="form-label">ชื่อสินค้า:</label>
                <input type="text" name="prd_name" id="prd_name" class="form-control" value="<?php echo $prd_name; ?>">
            </div>
            <div class="mb-3">
                <label for="prd_desc" class="form-label">รายละเอียดสินค้า:</label>
                <textarea name="prd_desc" id="prd_desc" rows="4" class="form-control" required><?php echo $prd_desc; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="prd_name" class="form-label">ราคาสินค้า:</label>
                <input type="number" name="prd_price" id="prd_price" class="form-control" min="1" value="<?php echo $prd_price; ?>">
            </div>
            <!-- New image upload -->
            <div class="mb-3">
                <label for="new_image" class="form-label">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน):</label>
                <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*">
                <div id="preview-image"></div>
            </div>
            <!-- Current image -->
            <label for="existing_images" class="form-label">รูปภาพปัจจุบัน:</label>
            <div class="row">
            <?php
// Fetch and display existing additional images associated with the product
$query_existing_images = "SELECT * FROM product WHERE prd_id = '$prd_id'";
$result_existing_images = $proj_connect->query($query_existing_images);

if ($result_existing_images->num_rows > 0) {
    $row_existing_image = $result_existing_images->fetch_assoc();
    $existing_image_id = $row_existing_image['prd_id']; // Get the ID of the image record
    $existing_image_path = $row_existing_image['prd_img'];
    echo '<div class="col-3 mb-3">';
    echo '<div class="image-container">';
    echo "<img src='$existing_image_path'  style='max-width: 100px; max-height: 100px;' class='img-fluid'>";
    
    // เปลี่ยนที่นี่เพื่อให้ปุ่ม Delete แสดงหรือซ่อนตามเงื่อนไข
    if ($existing_image_path) {
        echo ' <a class="delete-link" href="delete_current_img.php?prd_id=' . $prd_id . '">Delete</a>';
    }
    
    echo '</div>';
    echo '</div>';
} else {
    echo "ไม่มีรูปภาพในระบบ";
}
?>

            </div>
            <!-- Image preview -->
            <div class="mb-3">
                <label for="imagePreview" class="form-label">รูปตัวอย่าง (ถ้ามีการเปลี่ยน):</label>
                <div id="preview-image"></div>
            </div>
            <!-- Additional images upload -->
            <!-- Existing additional images -->
            <div class="mb-3">
                <label for="existing_images" class="form-label">รูปภาพเพิ่มเติม (รูปเก่า):</label>
                <div class="row">
                    <?php
                    // Fetch and display existing additional images associated with the product
                    $query_existing_images = "SELECT * FROM product_img WHERE prd_id = '$prd_id'";
                    $result_existing_images = $proj_connect->query($query_existing_images);

                    if ($result_existing_images->num_rows > 0) {
                        while ($row_existing_image = $result_existing_images->fetch_assoc()) {
                            $existing_image_id = $row_existing_image['img_id']; // Get the ID of the image record
                            $existing_image_path = $row_existing_image['img'];
                            echo '<div class="col-3 mb-3">';
                            echo '<div class="image-container">';
                            echo "<img src='$existing_image_path' alt='รูปภาพเพิ่มเติม' style='max-width: 100px; max-height: 100px;' class='img-fluid'>";
                            echo ' <a class="delete-link" href="delete_image.php?img_id=' . $existing_image_id . '&prd_id=' . $prd_id . '">Delete</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "ไม่มีรูปภาพเพิ่มเติม (รูปเก่า)";
                    }
                    ?>
                </div>
            </div>



            <!-- New additional images upload -->
            <div class="mb-3">
                <label for="additional_images" class="form-label">เลือกรูปภาพเพิ่มเติม (รูปใหม่):</label>
                <input type="file" name="additional_images[]" id="additional_images" class="form-control" accept="image/*" multiple>
                <div id="preview-images"></div>
            </div>

            <div class="mb-3">
                <label for="pty_id" class="form-label">Product Type:</label>
                <select name="pty_id" id="pty_id" class="form-control">
                    <option value="3" <?php if ($pty_id == 3) echo "selected"; ?>>..กรุณาเลือก..</option>
                    <?php
                    // Retrieve product type data from the database
                    $query_pty = "SELECT * FROM product_type ORDER BY CONVERT(pty_name USING tis620) ASC";
                    $pty = mysqli_query($proj_connect, $query_pty) or die(mysqli_error($proj_connect));

                    // Loop to display product type options
                    while ($row_pty = mysqli_fetch_assoc($pty)) {
                    ?>
                        <option value="<?php echo $row_pty['pty_id']; ?>" <?php if ($pty_id == $row_pty['pty_id']) echo "selected"; ?>>
                            <?php echo $row_pty['pty_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="prd_show" class="form-label">Product_show:</label>
                <select id="prd_show" name="prd_show" class="form-control">
                    <option value="4">..กรุณาเลือก..</option>
                    <option value="0" <?php if ($prd_show == 0) echo "selected"; ?>>ไม่แสดง</option>
                    <option value="1" <?php if ($prd_show == 1) echo "selected"; ?>>แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prd_reccom" class="form-label">Product_reccom:</label>
                <select id="prd_reccom" name="prd_reccom" class="form-control">
                    <option value="4">..กรุณาเลือก..</option>
                    <option value="0" <?php if ($prd_reccom == 0) echo "selected"; ?>>ไม่แสดง</option>
                    <option value="1" <?php if ($prd_reccom == 1) echo "selected"; ?>>แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
            </div>
        </form>
    </div>

    <script>
        // Function to preview selected image
        function previewImage(input) {
            var imagePreview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.style.display = 'block';
                    imagePreview.style.maxWidth = '100px';
                    imagePreview.style.maxHeight = '100px';
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.src = '#';
            }
        }
    </script>
    <script type="text/javascript">
        function chkdata(boarddata) {
            txtError = "กรุณากรอก";
            showError = 0;

            if (boarddata.prd_name.value == "") {
                showError = 1;
                txtError = txtError + " ชื่อสินค้า";
            }

            if (boarddata.prd_desc.value == "") {
                showError = 1;
                txtError = txtError + " คำอธิบาย";
            }

            // You have commented out the price field, so it won't be checked.
            // Uncomment it if needed.

            if (boarddata.prd_price.value == "") {
                showError = 1;
                txtError = txtError + " ราคาสินค้า";
            }

            // if (boarddata.new_image.value == "") {
            //     showError = 1;
            //     txtError = txtError + " รูป";
            // }

            if (boarddata.pty_id.value == "") {
                showError = 1;
                txtError = txtError + " ประเภทสินค้า";
            }

            if (boarddata.prd_show.value == "4") {
                showError = 1;
                txtError = txtError + " การแสดง";
            }

            if (showError == 1) {
                alert(txtError);
                return false;
            }

            return true; // Allow the form to submit when data is valid
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainImageInput = document.getElementById('new_image'); // เปลี่ยนชื่อตัวแปร
            const additionalImagesInput = document.getElementById('new_image');
            const previewImagesDiv = document.getElementById('preview-image');

            additionalImagesInput.addEventListener('change', function() {
                previewImagesDiv.innerHTML = '';

                if (this.files && this.files.length > 0) {
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];
                        if (file.type.startsWith('image/')) {
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('image-container');

                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.classList.add('preview-image');
                            img.style.maxWidth = '100px';
                            img.style.maxHeight = '100px';

                            const deleteButton = document.createElement('button');
                            deleteButton.textContent = 'Delete';
                            deleteButton.classList.add('delete-button');

                            deleteButton.addEventListener('click', function() {
                                // ลบรูปภาพ
                                imgContainer.remove();

                                // สร้างรายการไฟล์ใหม่ที่ไม่รวมไฟล์ที่ถูกลบ
                                const updatedFiles = Array.from(additionalImagesInput.files)
                                    .filter(inputFile => inputFile !== file);

                                // สร้าง FileList ใหม่
                                const newFileList = new DataTransfer();
                                updatedFiles.forEach(updatedFile => {
                                    newFileList.items.add(updatedFile);
                                });

                                // กำหนด FileList ใหม่ใน input
                                additionalImagesInput.files = newFileList.files;
                            });

                            imgContainer.appendChild(img);
                            imgContainer.appendChild(deleteButton);

                            previewImagesDiv.appendChild(imgContainer);
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainImageInput = document.getElementById('additional_images'); // เปลี่ยนชื่อตัวแปร
            const additionalImagesInput = document.getElementById('additional_images');
            const previewImagesDiv = document.getElementById('preview-images');

            additionalImagesInput.addEventListener('change', function() {
                previewImagesDiv.innerHTML = '';

                if (this.files && this.files.length > 0) {
                    for (let i = 0; i < this.files.length; i++) {
                        const file = this.files[i];
                        if (file.type.startsWith('image/')) {
                            const imgContainer = document.createElement('div');
                            imgContainer.classList.add('image-container');

                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.classList.add('preview-images');
                            img.style.maxWidth = '100px';
                            img.style.maxHeight = '100px';

                            const deleteButton = document.createElement('button');
                            deleteButton.textContent = 'Delete';
                            deleteButton.classList.add('delete-button');

                            deleteButton.addEventListener('click', function() {
                                // ลบรูปภาพ
                                imgContainer.remove();

                                // สร้างรายการไฟล์ใหม่ที่ไม่รวมไฟล์ที่ถูกลบ
                                const updatedFiles = Array.from(additionalImagesInput.files)
                                    .filter(inputFile => inputFile !== file);

                                // สร้าง FileList ใหม่
                                const newFileList = new DataTransfer();
                                updatedFiles.forEach(updatedFile => {
                                    newFileList.items.add(updatedFile);
                                });

                                // กำหนด FileList ใหม่ใน input
                                additionalImagesInput.files = newFileList.files;
                            });

                            imgContainer.appendChild(img);
                            imgContainer.appendChild(deleteButton);

                            previewImagesDiv.appendChild(imgContainer);
                        }
                    }
                }
            });
        });
    </script>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>