<?php
require_once('../../../connect/connect.php');


if (isset($_GET['t_id'])) {
    $t_id = $_GET['t_id'];

    $sql = "SELECT * FROM tradition WHERE t_id = '$t_id'";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $t_name = $row['t_name'];
        $t_detail = $row['t_detail'];
        $t_show = $row['t_show'];
        $t_reccom = $row['t_reccom'];
        $t_img = $row['t_img'];
    } else {
        echo "ไม่พบประเพณีที่ต้องการแก้ไข";
        exit;
    }
} else {
    echo "ไม่ระบุรหัสประเพณีที่ต้องการแก้ไข";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_t_name = $_POST["t_name"];
    $new_t_detail = $_POST["t_detail"];
    $new_t_show = $_POST["t_show"];
    $new_t_reccom = $_POST["t_reccom"];

    if ($_FILES["new_image"]["name"]) {
        $new_image = $_FILES["new_image"];
        $targetDirectory = "tradition_img/";
        $targetFile = $targetDirectory . basename($new_image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // Missing closing parenthesis here

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

                if (file_exists($t_img)) {
                    unlink($t_img);
                }

                $update_sql = "UPDATE tradition SET t_name = '$new_t_name', t_detail = '$new_t_detail', t_img = '$targetFile', t_show = '$new_t_show', t_reccom  = '$new_t_reccom' WHERE t_id = '$t_id'";
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
        $update_sql = "UPDATE tradition SET t_name = '$new_t_name', t_detail = '$new_t_detail', t_show = '$new_t_show', t_reccom  = '$new_t_reccom' WHERE t_id = '$t_id'";
        if ($proj_connect->query($update_sql) === TRUE) {
            $edit_success = true;
        } else {
            echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
        }
    }

    if (!empty($_FILES["additional_images"]["name"][0])) {
        $traditionImgDirectory = "tradition_additional_img/$t_id/";

        if (!file_exists($traditionImgDirectory)) {
            mkdir($traditionImgDirectory, 0777, true);
        }

        foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
            $img_name = $_FILES["additional_images"]["name"][$key];
            $img_tmp_name = $_FILES["additional_images"]["tmp_name"][$key];
            $img_target = $traditionImgDirectory . basename($img_name);

            // Check if the file is an image
            $check = getimagesize($img_tmp_name);
            if ($check === false) {
                echo "<script type='text/javascript'>";
                echo "alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, PNG และ GIF เท่านั้น.');";
                echo "window.location = 'tradition_edit.php'; ";
                echo "</script>";
                exit;
            }

            $imageFileType = strtolower(pathinfo($img_target, PATHINFO_EXTENSION));

            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<script type='text/javascript'>";
                echo "alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, PNG และ GIF เท่านั้น.');";
                echo "window.location = 'tradition_edit.php'; ";
                echo "</script>";
                exit;
            }

            if (move_uploaded_file($img_tmp_name, $img_target)) {
                $sql = "INSERT INTO tradition_img (t_id, img, img_show) VALUES ('$t_id', '$img_target', '1')";

                if ($proj_connect->query($sql) !== TRUE) {
                    echo "ข้อผิดพลาดในการบันทึกข้อมูลรูปภาพ: " . $proj_connect->error;
                }
            } else {
                echo "ข้อผิดพลาดใการอัพโหลดรูปภาพ: $img_name<br>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

<?php include ('../../web_stuc/head.php');?>
<body id="page-top">


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
                <?php include ('../../web_stuc/top_bar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">
    <h2>แก้ไขประเพณี</h2>
    <form action="" method="post" enctype="multipart/form-data" onSubmit="return chkdata(this);">
        <div class="mb-3">
            <label for="t_name" class="form-label">ชื่อประเพณี:</label>
            <input type="text" name="t_name" id="t_name" class="form-control" value="<?php echo $t_name; ?>">
        </div>
        <div class="mb-3">
            <label for="t_detail" class="form-label">รายละเอียดประเพณี:</label>
            <textarea name="t_detail" id="summernote" rows="4" class="form-control"><?php echo $t_detail; ?></textarea>
        </div>
        <!-- New image upload -->
        <div class="mb-3">
            <label for="new_image" class="form-label">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน):</label>
            <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*" onchange="checkFileType(this)">
            <div id="preview-image"></div>
        </div>
        <!-- Current image -->
        <label for="existing_images" class="form-label">รูปภาพปัจจุบัน:</label>
            <div class="row">
            <?php
// Fetch and display existing additional images associated with the product
$query_existing_images = "SELECT * FROM tradition WHERE t_id = '$t_id'";
$result_existing_images = $proj_connect->query($query_existing_images);

if ($result_existing_images->num_rows > 0) {
    $row_existing_image = $result_existing_images->fetch_assoc();
    $existing_image_id = $row_existing_image['t_id']; // Get the ID of the image record
    $existing_image_path = $row_existing_image['t_img'];
    $existing_image_name = $row_existing_image['t_name'];
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
        <!-- Additional images upload -->
        <!-- Existing additional images -->
        <div class="mb-3">
            <label for="existing_images" class="form-label">รูปภาพเพิ่มเติม (รูปเก่า):</label>
            <div class="row">
                <?php
                // Fetch and display existing additional images associated with the tradition
                $query_existing_images = "SELECT * FROM tradition_img WHERE t_id = '$t_id'";
                $result_existing_images = $proj_connect->query($query_existing_images);

                if ($result_existing_images->num_rows > 0) {
                    while ($row_existing_image = $result_existing_images->fetch_assoc()) {
                        $existing_image_id = $row_existing_image['img_id']; // Get the ID of the image record
                        $existing_image_path = $row_existing_image['img'];
                        echo '<div class="col-3 mb-3">';
                        echo '<div class="image-container">';
                        echo "<img src='$existing_image_path' alt='รูปภาพเพิ่มเติม' style='max-width: 100px; max-height: 100px;' class='img-fluid'>";
                        echo '<a class="btn btn-danger" onclick="confirmDeleteImageAddition(\'' .  $t_id. '\', \'' .   $existing_image_id  . '\')">Delete</a>';
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
            <input type="file" name="additional_images[]" id="additional_images" class="form-control" accept="image/*" onchange="check2FileType(this)" multiple>
            <div id="preview-images"></div>
        </div>

        <div class="mb-3">
            <label for="t_show" class="form-label">แสดงประเพณี:</label>
            <select id="t_show" name="t_show" class="form-control" >
                <option value="" >..กรุณาเลือก..</option>
                <option value="0" <?php if ($t_show == 0) echo "selected"; ?> required>ไม่แสดง</option>
                <option value="1" <?php if ($t_show == 1) echo "selected"; ?> required>แสดง</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="t_reccom" class="form-label">แสดงแนะนำประเพณี:</label>
            <select id="t_reccom" name="t_reccom" class="form-control">
                <option value="">..กรุณาเลือก..</option>
                <option value="0" <?php if ($t_reccom == 0) echo "selected"; ?>>ไม่แสดง</option>
                <option value="1" <?php if ($t_reccom == 1) echo "selected"; ?>>แสดง</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
            <a href="../tradition/" class="btn btn-secondary">cancel</a>
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
  <script>
function chkdata(form) {
    var errorMessage = "โปรดระบุ";
    showError = 0;

    // Check if the name field is empty
    if (form.t_name.value === "") {
        errorMessage += " ชื่อ";
        showError = 1;
    }

    // Check if the surname field is empty
    if (form.t_detail.value === "") {
        errorMessage += " รายละเอียด";
        showError = 1;
    }
 
    // Check if the address field is empty
    if (form.t_show.value === "") {
        errorMessage += " แสดงประเพณี";
        showError = 1;
    }
    if (form.t_reccom.value === "") {
        errorMessage += " แนะนำประเพณี";
        showError = 1;
    }

 

    // Display a single alert message with all the empty fields and validation errors

    if (showError == 1) {
            alert(errorMessage);
            return false;
        }

    return true;
}
</script>



<!-- edit success script -->
<?php if (isset($edit_success) && $edit_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!!',
                text: 'แก้ไขข้อมูลเรียบร้อย!!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '../tradition/';
            });
        </script>
    <?php endif; ?>
<!-- edit success script -->

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
    
    <!-- type file check -->
    <script type="text/javascript">
function checkFileType(fileInput) {
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;  // ระบุสกุลไฟล์ที่ยอมรับ

    if (!allowedExtensions.exec(filePath)) {
        alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์รูปภาพเท่านั้น: .jpg, .jpeg, .png, .gif');
        fileInput.value = '';
        return false;
    }
    return true;
}
</script>
<script type="text/javascript">
    function check2FileType(fileInput) {
        var files = fileInput.files;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var fileName = file.name;
            var fileExtension = fileName.split('.').pop().toLowerCase();
            var allowedExtensions = ["jpg", "jpeg", "png", "gif"];

            if (allowedExtensions.indexOf(fileExtension) === -1) {
                alert('ขออภัย, ไฟล์ ' + fileName + ' ไม่ใช่รูปภาพที่ยอมรับ: .jpg, .jpeg, .png, .gif');
                fileInput.value = ''; // เคลียร์ค่า input ที่มีไฟล์ที่ไม่ถูกต้อง
                return false;
            }
        }

        return true;
    }
</script>



  


<script>
    function confirmDelete(t_id,t_name) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบรูป "${t_name}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`delete_current_img.php?t_id=${t_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                                // รีโหลดหน้าหลังจากลบสำเร็จ
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('ลบไม่สำเร็จ', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ', error);
                        Swal.fire('ข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                    });
            }
        });
    }
</script>

<script>
    function confirmDeleteImageAddition(t_id,img_id) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบรูป"${img_id}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`delete_image.php?img_id=${img_id}&t_id=${t_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                                // รีโหลดหน้าหลังจากลบสำเร็จ
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('ลบไม่สำเร็จ', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ', error);
                        Swal.fire('ข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                    });
            }
        });
    }
</script>

    <!-- type file check -->
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
          <?php include ('../../web_stuc/footer.php');?>
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
    <?php include ('../../web_stuc/end_script.php');?>

</body>

</html>