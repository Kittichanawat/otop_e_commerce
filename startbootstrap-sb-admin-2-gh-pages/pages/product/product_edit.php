<?php
require_once('../../../connect/connect.php');


if (isset($_GET['prd_id'])) {
    $prd_id = $_GET['prd_id'];

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
        // $prd_promotion = $row['prd_promotion '];
        // $price_promotion = $row['price_promotion '];
        $prd_img = $row['prd_img'];
        
    } else {
        echo "ไม่พบสินค้าที่ต้องการแก้ไข";
        exit;
    }
} else {
    echo "ไม่ระบุรหัสสินค้าที่ต้องการแก้ไข";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_prd_name = $_POST["prd_name"];
    $new_prd_desc = $_POST["prd_desc"];
    $new_prd_price = $_POST['prd_price'] ?? ''; 
    $new_pty_id = $_POST["pty_id"];
    $new_prd_show = $_POST["prd_show"];
    $new_prd_reccom = $_POST["prd_reccom"];
    $prd_promotion = $_POST["prd_promotion"];
    $prd_promotion_price= $_POST["prd_promotion_price"];
    
     // Check for promotional pricing

 
     // Determine the final price to use
 
    
        if ($new_prd_name != $prd_name) {
            // ตรวจสอบว่าชื่อสินค้าใหม่ไม่ซ้ำกับชื่อสินค้าอื่นในฐานข้อมูล
            $checkNameQuery = "SELECT prd_name FROM product WHERE prd_name = '$new_prd_name' AND prd_id != '$prd_id'";
            $checkNameResult = $proj_connect->query($checkNameQuery);
    
            if ($checkNameResult->num_rows > 0) {
                echo "<script type='text/javascript'>";
                echo "alert('ชื่อสินค้าซ้ำกัน กรุณาเลือกชื่ออื่น.');";
                echo "window.location = 'product_edit.php?prd_id=$prd_id'; ";
                echo "</script>";
                exit;
            }
        }
    

    if ($_FILES["new_image"]["name"]) {
        $new_image = $_FILES["new_image"];
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($new_image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($new_image["tmp_name"]);
        if ($check === false) {
            echo "ไฟล์ไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }

        if ($new_image["size"] > 500000) {
            echo "ขออภัย, ไฟล์มีขนาดใหญ่เกินไป.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "ขออภัย, ไม่สามารถอัพโหลดไฟล์ได้.";
        } else {
            if (move_uploaded_file($new_image["tmp_name"], $targetFile)) {
                echo "ไฟล์ " . htmlspecialchars(basename($new_image["name"])) . " อัพโหลดเรียบร้อย.";

                if (file_exists($prd_img)) {
                    unlink($prd_img);
                }

                $update_sql = "UPDATE product SET prd_name = '$new_prd_name', prd_desc = '$new_prd_desc', prd_price = '$new_prd_price', prd_img = '$targetFile', pty_id = '$new_pty_id', prd_show = '$new_prd_show', prd_reccom = '$new_prd_reccom', prd_promotion = '$prd_promotion', price_promotion = '$prd_promotion_price 'WHERE prd_id = '$prd_id'";
                if ($proj_connect->query($update_sql) === TRUE) {
                    $edit_success = true;
                } else {
                    echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
                }
            } else {
                echo "ข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        }
    } else {
        $update_sql = "UPDATE product SET prd_name = '$new_prd_name', prd_desc = '$new_prd_desc',prd_price = '$new_prd_price', pty_id = '$new_pty_id', prd_show = '$new_prd_show', prd_reccom  = '$new_prd_reccom', prd_promotion = '$prd_promotion', price_promotion = '$prd_promotion_price '  WHERE prd_id = '$prd_id'";
        if ($proj_connect->query($update_sql) === TRUE) {
            $edit_success = true;
         
        } else {
            echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
        }
    }

   if (!empty($_FILES["additional_images"]["name"][0])) {
    $productImgDirectory = "product_img/$prd_id/";

    if (!file_exists($productImgDirectory)) {
        mkdir($productImgDirectory, 0777, true);
    }

    foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
        $img_name = $_FILES["additional_images"]["name"][$key];
        $img_tmp_name = $_FILES["additional_images"]["tmp_name"][$key];
        $img_target = $productImgDirectory . basename($img_name);

        // Check if the file is an image
        $check = getimagesize($img_tmp_name);
        if ($check === false) {
            echo "<script type='text/javascript'>";
            echo "alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, PNG และ GIF เท่านั้น.');";
            echo "window.location = 'product_add_copy.php'; ";
            echo "</script>";
            exit;
        }

        $imageFileType = strtolower(pathinfo($img_target, PATHINFO_EXTENSION));

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script type='text/javascript'>";
            echo "alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, PNG และ GIF เท่านั้น.');";
            echo "window.location = 'product_add_copy.php'; ";
            echo "</script>";
            exit;
           
        }

        if (move_uploaded_file($img_tmp_name, $img_target)) {
            $sql = "INSERT INTO product_img (prd_id, img, img_show) VALUES ('$prd_id', '$img_target', '1')";

            if ($proj_connect->query($sql) !== TRUE) {
                echo "ข้อผิดพลาดในการบันทึกข้อมูลรูปภาพ: " . $proj_connect->error;
            }
        } else {
            echo "ข้อผิดพลาดในการอัพโหลดรูปภาพ: $img_name<br>";
        }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">
<?php if (isset($edit_success) && $edit_success) : ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ!!',
        text: 'แก้ไขข้อมูลเรียบร้อย!!',
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
        window.location.href = '../product/';
    });
    </script>
    <?php endif; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('../../web_stuc/side_bar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('../../web_stuc/top_bar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">
                    <h2>แก้ไขสินค้า</h2>
                    <form action="" method="post" enctype="multipart/form-data" onSubmit="return(chkdata(this));">
                        <div class="mb-3">
                            <label for="prd_name" class="form-label">ชื่อสินค้า:</label>
                            <input type="text" name="prd_name" id="prd_name" class="form-control"
                                value="<?php echo $prd_name; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="prd_desc" class="form-label">รายละเอียดสินค้า:</label>
                            <textarea id="summernote" name="prd_desc" id="prd_desc" rows="4" class="form-control"
                                required><?php echo $prd_desc; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prd_name" class="form-label">ราคาสินค้า:</label>
                            <input type="number" name="prd_price" id="prd_price" class="form-control" min="1"
                                value="<?php echo $prd_price; ?>">
                        </div>
                        <input type="hidden" name="calculated_discount_percentage" id="calculated_discount_percentage" value="">
    <input type="hidden" name="calculated_original_price" id="calculated_original_price" value="">
    <input type="hidden" name="calculated_promotional_price" id="calculated_promotional_price" value="">
        
                        <!-- New image upload -->
                        <div class="mb-3">
                            <label for="new_image" class="form-label">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน):</label>
                            <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*"
                                onchange="checkFileType(this)">
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
    $existing_image_name = $row_existing_image['prd_name']; // Get the name of the image
    echo '<div class="col-3 mb-3">';
    echo '<div class="image-container">';
    echo "<img src='$existing_image_path'  style='max-width: 100px; max-height: 100px;' class='img-fluid'>";
    
    // เปลี่ยนที่นี่เพื่อให้ปุ่ม Delete แสดงหรือซ่อนตามเงื่อนไข
    if ($existing_image_path) {
        echo '<a class="btn btn-danger" onclick="confirmDelete(\'' . $existing_image_id . '\', \'' . $existing_image_name . '\')">Delete</a>';
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
                            echo '<a class="btn btn-danger" onclick="confirmDeleteImageAddition(\'' .  $prd_id. '\', \'' .   $existing_image_id  . '\')">Delete</a>';
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
                            <input type="file" name="additional_images[]" id="additional_images" class="form-control"
                                accept="image/*" onchange="check2FileType(this)" multiple>
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
                                <option value="<?php echo $row_pty['pty_id']; ?>"
                                    <?php if ($pty_id == $row_pty['pty_id']) echo "selected"; ?>>
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
    <label for="prd_promotion" class="form-label">สถานะโปรโมชั่น:</label>
    <select id="prd_promotion" name="prd_promotion" class="form-control" onchange="togglePromotionField()">
        <option value="0" selected>สินค้าไม่โปรโมชั่น</option>
        <option value="1">สินค้าโปรโมชั่น</option>
    </select>
</div>
<div class="mb-3">
    <label for="prd_promotion_price" class="form-label">ราคาโปรโมชั่น:</label>
    <input type="number" name="prd_promotion_price" id="prd_promotion_price" class="form-control" min="1" readonly>
</div>
<input type="hidden" name="discount_percentage" id="hidden-discount-percentage">
    <input type="hidden" name="original_price" id="hidden-original-price">
    <input type="hidden" name="promotional_price" id="hidden-promotional-price">
                        <div class="mb-3">
                            <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
                            <a href="../product/" class="btn btn-secondary">cancel</a>
                        </div>
                    </form>
                </div>
      



             


                <!-- type file check -->
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('../../web_stuc/footer.php');?>
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
    <script>
      $('#summernote').summernote({
        placeholder: 'Hello stand alone ui',
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    </script>
    <?php include('../../web_stuc/end_script.php');?>
<script src="../../js/product.js"></script>
</body>

</html>