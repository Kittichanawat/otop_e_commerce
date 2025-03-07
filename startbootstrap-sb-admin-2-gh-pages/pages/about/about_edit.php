<?php
require_once('../../../connect/connect.php');


if (isset($_GET['a_id'])) {
    $a_id = $_GET['a_id'];

    $sql = "SELECT * FROM about WHERE a_id = '$a_id'";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $a_title = $row['a_title'];
        $a_detail = $row['a_detail'];
        $a_img = $row['a_img'];
        $a_link = $row['a_link'];
        $a_show = $row['a_show'];
    } else {
        echo "ไม่พบหน้าที่ต้องการแก้ไข";
        exit;
    }
} else {
    echo "ไม่ระบุรหัสหน้าที่ต้องการแก้ไข";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_a_title = $_POST["a_title"];
    $new_a_detail = $_POST["a_detail"];
    $new_a_show = $_POST["a_show"];
    $new_a_link = $_POST["a_link"];

    if ($_FILES["new_image"]["name"]) {
        $new_image = $_FILES["new_image"];
        $targetDirectory = "about_img/";
        $originalFileName = basename($new_image["name"]);
        $targetFile = $targetDirectory . $originalFileName;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        $check = getimagesize($new_image["tmp_name"]);
        if ($check === false) {
            echo "ไฟล์ไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            echo "ขออภัย, ไม่สามารถอัพโหลดไฟล์ได้.";
        } else {
            // ตรวจสอบว่าชื่อไฟล์ที่อัพโหลดซ้ำกับไฟล์ที่มีอยู่แล้วหรือไม่
            $counter = 1;
            while (file_exists($targetFile)) {
                $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
                $newFileName = $fileNameWithoutExtension . '_' . $counter . '.' . $imageFileType;
                $targetFile = $targetDirectory . $newFileName;
                $counter++;
            }
    
            // อัพโหลดไฟล์ใหม่
            if (move_uploaded_file($new_image["tmp_name"], $targetFile)) {
                echo "ไฟล์ " . htmlspecialchars(basename($targetFile)) . " อัพโหลดเรียบร้อย.";
    
                if (file_exists($a_img)) {
                    unlink($a_img);
                }
    
                $update_sql = "UPDATE about SET a_title = '$new_a_title', a_detail = '$new_a_detail', a_img = '$targetFile', a_link = '$new_a_link', a_show = '$new_a_show' WHERE a_id = '$a_id'";
                if ($proj_connect->query($update_sql) === TRUE) {
                    header("Location: ../about/");
                } else {
                    echo "ข้อผิดพลาดในการแก้ไขหน้า: " . $proj_connect->error;
                }
            } else {
                echo "ข้อผิดพลาดในการอัพโหลดไฟล์.";
            }
        }
    
    } else {
        $update_sql = "UPDATE about SET a_title = '$new_a_title', a_detail = '$new_a_detail',  a_link = '$new_a_link',a_show = '$new_a_show' WHERE a_id = '$a_id'";
        if ($proj_connect->query($update_sql) === TRUE) {
            $edit_success = true;
        } else {
            echo "ข้อผิดพลาดในการแก้ไขหน้า: " . $proj_connect->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

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
                <?php include('../../web_stuc/top_bar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">
    <h2>แก้ไขหน้า</h2>
    <form action="" method="post"   enctype="multipart/form-data" onSubmit="return chkdata(this);">
        <div class="mb-3">
            <label for="a_title" class="form-label">ชื่อหน้า:</label>
            <input type="text" name="a_title" id="a_title" class="form-control" value="<?php echo $a_title; ?>">
        </div>
        <div class="mb-3">
            <label for="a_detail" class="form-label">รายละเอียดหน้า:</label>
            <textarea name="a_detail" id="a_detail" rows="4" class="form-control" ><?php echo $a_detail; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="a_link" class="form-label">ลิงค์:</label>
            <textarea name="a_link" id="a_link" rows="4" class="form-control" ><?php echo $a_link; ?></textarea>
        </div>
        <label for="existing_images" class="form-label">รูปภาพปัจจุบัน:</label>
        <div class="row">
            <?php
            // Fetch and display existing images associated with the page
            $query_existing_images = "SELECT * FROM about WHERE a_id = '$a_id'";
            $result_existing_images = $proj_connect->query($query_existing_images);

            if ($result_existing_images->num_rows > 0) {
                $row_existing_image = $result_existing_images->fetch_assoc();
                $existing_image_id = $row_existing_image['a_id']; // Get the ID of the image record
                $existing_image_path = $row_existing_image['a_img'];
                echo '<div class="col-3 mb-3">';
                echo '<div class="image-container">';
                echo "<img src='$existing_image_path'  style='max-width: 100px; max-height: 100px;' class='img-fluid'>";

                // เปลี่ยนที่นี่เพื่อให้ปุ่ม Delete แสดงหรือซ่อนตามเงื่อนไข
                if ($existing_image_path) {
                    echo '<a class="btn btn-danger" onclick="confirmDelete(\'' . $a_id . '\')">Delete</a>';
                }

                echo '</div>';
                echo '</div>';
            } else {
                echo "ไม่มีรูปภาพในระบบ";
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="new_image" class="form-label">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน):</label>
            <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*" onchange="checkFileType(this)">
            <div id="preview-image"></div>
        </div>
        <div class="mb-3">
                <label for="a_show" class="form-label">แสดงเกี่ยวกับ:</label>
                <select id="a_show" name="a_show" class="form-control " required>
                    <option value="" required>..กรุณาเลือก..</option>
                    <option value="0" <?php if ($a_show == 0) echo "selected"; ?> required>ไม่แสดง</option>
                    <option value="1" <?php if ($a_show == 1) echo "selected"; ?> required>แสดง</option>
                </select>
            </div>
       
        <div class="mb-3">
            <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
            <a href="../about/" class="btn btn-secondary">cancel</a>
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
    if (form.a_title.value === "") {
        errorMessage += " หัวข้อ";
        showError = 1;
    }

    // Check if the surname field is empty
    if (form.a_detail.value === "") {
        errorMessage += " รายละเอียด";
        showError = 1;
    }
 
    // Check if the address field is empty
    if (form.a_show.value === "") {
        errorMessage += " แสดงหน้าต่างๆ";
        showError = 1;
    }
 
    // Check if the address field is empty
    if (form.a_link.value === "") {
        errorMessage += " ลิงค์ต่างๆ";
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

<?php if (isset($edit_success) && $edit_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!!',
                text: 'แก้ไขข้อมูลเรียบร้อย',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '../about/';
            });
        </script>
    <?php endif; ?>

    <script>
    function confirmDelete(a_id) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบรูป "${a_id}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`delete_current_img.php?a_id=${a_id}`)
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

    <?php include('../../web_stuc/end_script.php');?>

</body>

</html>