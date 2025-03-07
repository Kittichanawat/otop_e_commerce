<?php
require_once('../../../connect/connect.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST["p_name"];
    $p_des = $_POST["p_des"];
    $p_addr = $_POST["p_addr"];
    $p_show = $_POST["p_show"];
    $p_reccom = $_POST["p_reccom"];
    $map = $_POST["map"];
    $time = $_POST["time"];
    $contact = $_POST["contact"];

    $targetDirectory = "place_img/";

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    if (!empty($_FILES["main_image"]["tmp_name"])) {
        $mainImgName = $_FILES["main_image"]["name"];
        $mainImgTmpName = $_FILES["main_image"]["tmp_name"];
        $mainImgTarget = $targetDirectory . basename($mainImgName);

        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
        $fileExtension = pathinfo($mainImgName, PATHINFO_EXTENSION);

        // if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        //     echo "ข้อผิดพลาด: ไฟล์หลักไม่ใช่ไฟล์รูปภาพ.";
        //     exit;
        // }

        if (move_uploaded_file($mainImgTmpName, $mainImgTarget)) {
            $mainImgPath = $mainImgTarget;
        } else {
            echo "ข้อผิดพลาดในการอัพโหลดไฟล์รูปภาพหลัก: " . $mainImgName;
            exit;
        }
    } else {
        echo "กรุณาเลือกไฟล์รูปภาพหลัก";
        exit;
    }

    $sql = "INSERT INTO tourist (p_name, p_des, p_addr, p_show, p_reccom,map, p_img,time,contact) 
            VALUES ('$p_name', '$p_des', '$p_addr', '$p_show', '$p_reccom','$map', '$mainImgPath','$time','$contact')";

    if ($proj_connect->query($sql) === TRUE) {
        $p_id = $proj_connect->insert_id;

        $placeImgDirectory = "place_additional_img/$p_id/";

        if (!file_exists($placeImgDirectory)) {
            mkdir($placeImgDirectory, 0777, true);
        }

        if (!empty($_FILES["additional_images"]["tmp_name"])) {
            foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
                $img_name = $_FILES["additional_images"]["name"][$key];
                $img_tmp_name = $_FILES["additional_images"]["tmp_name"][$key];
                $img_target = $placeImgDirectory . basename($img_name);

                $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                $fileExtension = pathinfo($img_name, PATHINFO_EXTENSION);

                // if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                //     echo "ข้อผิดพลาด: ไฟล์ $img_name ไม่ใช่ไฟล์รูปภาพ.";
                //     continue;
                // }

                if (move_uploaded_file($img_tmp_name, $img_target)) {
                    $sql = "INSERT INTO tourist_img (p_id, img, img_show) 
                            VALUES ('$p_id', '$img_target', '')";

                    if ($proj_connect->query($sql) !== TRUE) {
                        echo "ข้อผิดพลาดในการบันทึกข้อมูลรูปภาพ: " . $proj_connect->error;
                    }
                } else {
                    // echo "ข้อผิดพลาดในการอัพโหลดไฟล์ $img_name.";
                }
            }
        }

        $insert_success = true;
    } else {
        echo "ข้อผิดพลาดในการบันทึกข้อมูล: " . $proj_connect->error;
    }

    $proj_connect->close();
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
                    <h2>เพิ่มข้อมูลสถานที่</h2>
                    <form action="" method="post" enctype="multipart/form-data" onSubmit="return chkdata(this);" >
                        <div class="mb-3">
                            <label for="p_name" class="form-label">ชื่อสถานที่:</label>
                            <input type="text" name="p_name" id="p_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="p_desc" class="form-label">รายละเอียดสถานที่:</label>
                            <textarea name="p_des" id="p_des" rows="4" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="p_addr">ที่อยู่<br>

                            </label>
                            <textarea id="p_addr" class="form-control" name="p_addr"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="map" class="form-label">Google map:</label>
                            <input type="text" name="map" id="map" class="form-control">
                        </div>
                        
                        <!-- <div class="mb-3">
                <label for="main_image" class="form-label">เลือกรูปภาพสินค้า (หลัก):</label>
                <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*"
                    onchange="previewImage(this)">
            </div> -->
                        <div class="mb-3">
                            <label for="time" class="form-label">เวลาเปิด-ปิด:</label>
                            <input type="text" name="time" id="time" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">ข้อมูลการติดต่อ:</label>
                            <input type="text" name="contact" id="contact" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="main_image" class="form-label">เลือกรูปภาพสถานที่:</label>
                            <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*"
                                onchange="checkFileType(this)">
                            <div id="preview-image"></div>
                        </div>
                        <!-- แสดงรูปที่เลือก (ถ้ามี) -->
                        <!-- <img id="imagePreview" src="#" alt="รูปภาพ" style="display: none; max-width: 300px; max-height: 300px;"> -->
                        <div class="mb-3">
                            <label for="additional_images"
                                class="form-label">เลือกรูปภาพสถานที่เพิ่มเติม(เลือกได้หลายรูป):</label>
                            <input type="file" name="additional_images[]" id="additional_images" class="form-control"
                                accept="image/*" onchange="check2FileType(this)" multiple>
                            <div id="preview-images"></div>
                        </div>



                        <div class="mb-3">
                            <label for="p_reccom" class="form-label">แนะนำสถานที่:</label>
                            <select id="p_reccom" name="p_reccom" class="form-control">
                                <option value="" required>..กรุณาเลือก..</option>
                                <option value="0">ไม่แสดง</option>
                                <option value="1">แสดง</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="p_show" class="form-label">แสดงสถานที่:</label>
                            <select id="p_show" name="p_show" class="form-control">
                                <option value="" required>..กรุณาเลือก..</option>
                                <option value="0">ไม่แสดง</option>
                                <option value="1">แสดง</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="submit" value="เพิ่มถานที่" class="btn btn-primary">
                            <a href="../tourist/" class="btn btn-secondary">cancel</a>
                        </div>
                    </form>
                </div>


                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="script.js"></script>

                <script>
function chkdata(form) {
    var errorMessage = "โปรดระบุ";
    showError = 0;

    // Check if the name field is empty
    if (form.p_name.value === "") {
        errorMessage += " ชื่อ";
        showError = 1;
    }

    // Check if the surname field is empty
    if (form.p_des.value === "") {
        errorMessage += " รายละเอียด";
        showError = 1;
    }
    if (form.main_image.value === "") {
        errorMessage += " รูปภาพหลัก";
        showError = 1;
    }
    if (form.p_addr.value === "") {
        errorMessage += " ที่อยู่";
        showError = 1;
    }


    // Check if the address field is empty
    if (form.time.value === "") {
        errorMessage += " เวลาเปิด-ปิด";
        showError = 1;
    }
    if (form.contact.value === "") {
        errorMessage += " ข้อมูลการติดต่อ";
        showError = 1;
    }

 
    // Check if the email field is empty
    if (form.p_show.value === "") {
        errorMessage += " แสดงสถานที่ ";
        showError = 1;
    }

    // Check if the show field is empty
    if (form.p_reccom.value === "") {
        errorMessage += " สถานที่แนะนำ";
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







                <script type="text/javascript">
          
                function previewImage(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            // แสดงรูปภาพในแท็ก img
                            document.getElementById("preview").src = e.target.result;
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }

                function deleteImage() {

                    document.getElementById("main_image").value = "";
                }
                </script>



                <script>
                document.addEventListener('DOMContentLoaded', function() {
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
                                        const updatedFiles = Array.from(additionalImagesInput
                                                .files)
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
                    const mainImageInput = document.getElementById('main_image'); // เปลี่ยนชื่อตัวแปร
                    const additionalImagesInput = document.getElementById('main_image');
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
                                        const updatedFiles = Array.from(additionalImagesInput
                                                .files)
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
        <script type="text/javascript">
                function checkFileType(fileInput) {
                    var filePath = fileInput.value;
                    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; // ระบุสกุลไฟล์ที่ยอมรับ

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



                </script>

                <?php if (isset($insert_success) && $insert_success) : ?>
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: 'เพิ่มข้อมูลเรียบร้อย!!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = '../tourist/';
                });
                </script>
                <?php endif; ?>






                <!-- Add more product details as needed -->


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

    <!-- Bootstrap core JavaScript-->
    <?php include('../../web_stuc/end_script.php');?>

</body>

</html>