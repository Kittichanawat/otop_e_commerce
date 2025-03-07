<?php
require_once('../../../connect/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prd_name = $_POST["prd_name"];
    $prd_desc = $_POST["prd_desc"];
    $prd_price = $_POST["prd_price"];
    $pty_id = $_POST["pty_id"];
    $prd_show = $_POST["prd_show"];
    $prd_reccom = $_POST["prd_reccom"];
    $prd_promotion = $_POST["prd_promotion"];
    $prd_promotion_price = $_POST["prd_promotion_price"];

    // กำหนดโฟลเดอร์ที่จะใช้เก็บรูปภาพหลัก
    $targetDirectory = "uploads/";

    // ตรวจสอบว่าโฟลเดอร์ uploads มีอยู่หรือไม่ ถ้าไม่มีให้สร้าง
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    // ตรวจสอบว่าชื่อสินค้าไม่ซ้ำกัน
    $checkNameQuery = "SELECT prd_name FROM product WHERE prd_name = '$prd_name'";
    $checkNameResult = $proj_connect->query($checkNameQuery);

    if ($checkNameResult->num_rows > 0) {
        // ชื่อสินค้าซ้ำกัน
        echo "<script type='text/javascript'>";
        echo "alert('ชื่อสินค้าซ้ำกัน กรุณาเลือกชื่ออื่น.');";
        echo "window.location = 'product_add_copy.php'; ";
        echo "</script>";
        exit;
    }

    if (!empty($_FILES["main_image"]["tmp_name"])) {
        // กำหนดเส้นทางไฟล์รูปภาพหลัก
        $mainImgName = $_FILES["main_image"]["name"];
        $mainImgTmpName = $_FILES["main_image"]["tmp_name"];
        $mainImgTarget = $targetDirectory . basename($mainImgName);

        // ตรวจสอบว่ามีไฟล์รูปภาพถูกอัปโหลดหรือไม่
        if (!empty($mainImgTmpName)) {
            // ตรวจสอบว่าไฟล์เป็นรูปภาพ
            $check = getimagesize($mainImgTmpName);
            if ($check !== false) {
                $imageFileType = image_type_to_mime_type($check[2]);

                // อนุญาตให้เฉพาะประเภทไฟล์รูปภาพที่ระบุ
                $allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];
                if (in_array($imageFileType, $allowedImageTypes)) {
                    // เช็คว่าไฟล์ที่มีชื่อเดียวกันอยู่ในโฟลเดอร์หรือไม่
                    $count = 1;
                    $newMainImgName = $mainImgName;
                    while (file_exists($targetDirectory . $newMainImgName)) {
                        $newMainImgName = pathinfo($mainImgName, PATHINFO_FILENAME) . "_$count." . pathinfo($mainImgName, PATHINFO_EXTENSION);
                        $count++;
                    }
                    $mainImgTarget = $targetDirectory . $newMainImgName;

                    // อัพโหลดรูปภาพหลัก
                    if (move_uploaded_file($mainImgTmpName, $mainImgTarget)) {
                        // กำหนดเส้นทางไฟล์รูปภาพหลักให้กับฐานข้อมูล
                        $mainImgPath = $mainImgTarget;
                    } else {
                        echo "ข้อผิดพลาดในการอัพโหลดไฟล์รูปภาพหลัก: " . $mainImgName;
                        exit;
                    }
                } else {
                    echo "<script type='text/javascript'>";
                    echo "alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, PNG และ GIF เท่านั้น.');";
                    echo "window.location = 'product_add_copy.php'; ";
                    echo "</script>";
                    exit;
                }
            } else {
                echo "<script type='text/javascript'>";
                echo "alert('ไฟล์ไม่ใช่รูปภาพ');";
                echo "window.location = 'product_add_copy.php'; ";
                echo "</script>";
                exit;
            }
        }
    } else {
        echo "กรุณาเลือกไฟล์รูปภาพหลัก";
        exit;
    }
    if ($prd_promotion == '1' && !empty($prd_promotion_price)) {
        $final_price = $prd_promotion_price; // Use promotional price
    } else {
        $final_price = $prd_price; // Use regular price
    }
    // กำหนดคำสั่ง SQL เพื่อเพิ่มข้อมูลสินค้า
    $sql = "INSERT INTO product (prd_name, prd_desc, prd_price, pty_id, prd_show, prd_reccom, prd_img, prd_promotion) 
    VALUES ('$prd_name', '$prd_desc', '$final_price', '$pty_id', '$prd_show', '$prd_reccom', '$mainImgPath', '$prd_promotion')";

    if ($proj_connect->query($sql) === TRUE) {
        // รับค่า ID ของสินค้าที่เพิ่มล่าสุด
        $prd_id = $proj_connect->insert_id;

        // สร้างโฟลเดอร์ใหม่สำหรับรูปภาพของสินค้าโดยใช้ prd_id เป็นชื่อโฟลเดอร์
        $productImgDirectory = "product_img/$prd_id/";

        if (!file_exists($productImgDirectory)) {
            mkdir($productImgDirectory, 0777, true);
        }

        if (!empty($_FILES["additional_images"]["tmp_name"])) {
            foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
                $img_name = $_FILES["additional_images"]["name"][$key];
                $img_tmp_name = $_FILES["additional_images"]["tmp_name"][$key];

                // ตรวจสอบว่ามีไฟล์รูปภาพถูกอัปโหลดหรือไม่
                if (!empty($img_tmp_name)) {
                    $img_target = $productImgDirectory . basename($img_name);

                    // ตรวจสอบว่าไฟล์เป็นรูปภาพ
                    $check = getimagesize($img_tmp_name);
                    if ($check !== false) {
                        $imageFileType = image_type_to_mime_type($check[2]);

                        // อนุญาตให้เฉพาะประเภทไฟล์รูปภาพที่ระบุ
                        $allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];
                        if (in_array($imageFileType, $allowedImageTypes)) {
                            // อัพโหลดรูปภาพ
                            if (move_uploaded_file($img_tmp_name, $img_target)) {
                                // เพิ่มข้อมูลลงในตาราง product_img
                                $sql = "INSERT INTO product_img (prd_id, img, img_show) 
                                        VALUES ('$prd_id', '$img_target', '')";

                                if ($proj_connect->query($sql) !== TRUE) {
                                    echo "ข้อผิดพลาดในการบันทึกข้อมูลรูปภาพ: " . $proj_connect->error;
                                }
                            } else {
                                echo "<script type='text/javascript'>";
                                echo "alert('ข้อผิดพลาดในการอัพโหลดไฟล์ $img_name.');";
                                echo "window.location = 'product_add_copy.php'; ";
                                echo "</script>";
                                exit;
                            }
                        } else {
                            echo "<script type='text/javascript'>";
                            echo "alert('ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, PNG และ GIF เท่านั้น.');";
                            echo "window.location = 'product_add_copy.php'; ";
                            echo "</script>";
                            exit;
                        }
                    } else {
                        echo "<script type='text/javascript'>";
                        echo "alert('ไฟล์ไม่ใช่รูปภาพ: $img_name');";
                        echo "window.location = 'product_add_copy.php'; ";
                        echo "</script>";
                        exit;
                    }
                }
            }
        }

        $insert_success = true;
    } else {
        echo "ข้อผิดพลาดในการบันทึกข้อมูล: " . $proj_connect->error;
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
        <h2>เพิ่มสินค้า</h2>
        <form action="" method="post" enctype="multipart/form-data" >
            <div class="mb-3">
          
                <label for="prd_name" class="form-label">ชื่อสินค้า:</label>
                <input type="text" name="prd_name" id="prd_name" class="form-control">
                
            </div>
            <div  class="mb-3"> 
                <label for="prd_desc" class="form-label">รายละเอียดสินค้า:</label>
                <textarea id="summernote" name="prd_desc" id="prd_desc" rows="4" class="form-control"></textarea>
            </div>
       

            <div class="mb-3">
                <label for="prd_name" class="form-label">ราคาสินค้า:</label>
                <input type="number" name="prd_price" id="prd_price" class="form-control" min="1">
            </div>
            <!-- <div class="mb-3">
                <label for="main_image" class="form-label">เลือกรูปภาพสินค้า (หลัก):</label>
                <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*"
                    onchange="previewImage(this)">
            </div> -->
            <div class="mb-3">
                <label for="main_image" class="form-label">เลือกรูปภาพสินค้าหลัก:</label>
                <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*"onchange="checkFileType(this)" >
                <div id="preview-image"></div>
            </div>
            <!-- แสดงรูปที่เลือก (ถ้ามี) -->
            <!-- <img id="imagePreview" src="#" alt="รูปภาพ" style="display: none; max-width: 300px; max-height: 300px;"> -->
            <div class="mb-3">
                <label for="additional_images" class="form-label">เลือกรูปภาพสินค้าเพิ่มเติม(เลือกได้หลายรูป):</label>
                <input type="file" name="additional_images[]" id="additional_images" class="form-control"
                    accept="image/*" multiple onchange="check2FileType(this)">
                <div id="preview-images"></div>
            </div>


            <div class="mb-3">
                <label for="pty_id" class="form-label">Product Type:</label>
                <select name="pty_id" id="pty_id" class="form-control">
                    <option value="" selected>..กรุณาเลือก..</option>
                    <?php
                // เรียกข้อมูลประเภทสินค้าจากฐานข้อมูล
                $query_pty = "SELECT * FROM product_type ORDER BY CONVERT(pty_name USING tis620) ASC";
                $pty = mysqli_query($proj_connect, $query_pty) or die(mysqli_error($proj_connect));

                // วนลูปเพื่อแสดงรายการประเภทสินค้าในตัวเลือก
                while ($row_pty = mysqli_fetch_assoc($pty)) {
                    ?>
                    <option value="<?php echo $row_pty['pty_id']; ?>"><?php echo $row_pty['pty_name']; ?></option>
                    <?php
                }
                ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="prd_reccom" class="form-label">แนะนำสินค้า:</label>
                <select id="prd_reccom" name="prd_reccom" class="form-control">
                <option value="" selected>..กรุณาเลือก..</option>
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prd_show" class="form-label">แสดงสินค้า:</label>
                <select id="prd_show" name="prd_show" class="form-control">
                <option value="" selected>..กรุณาเลือก..</option>
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <div class="mb-3">
    <label for="prd_promotion" class="form-label">สถานะโปรโมชั่น:</label>
    <select id="prd_promotion" name="prd_promotion" class="form-control" onchange="togglePromotionPrice(this.value)">
        <option value="0" selected>สินค้าไม่โปรโมชั่น</option>
        <option value="1">สินค้าโปรโมชั่น</option>
    </select>
</div>
<div class="mb-3" id="promotionPriceSection" style="display: none;">
    <label for="prd_promotion_price" class="form-label">ราคาโปรโมชั่น:</label>
    <input type="number" name="prd_promotion_price" id="prd_promotion_price" class="form-control" min="1" disabled>
</div>

            <div class="mb-3">
                <input type="submit" name="submit" value="เพิ่มสินค้า" class="btn btn-primary">
                <a href="../product/" class="btn btn-secondary">cancel</a>
            </div>
        </form>
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



    <script>
function togglePromotionPrice(value) {
    var promotionPriceSection = document.getElementById('promotionPriceSection');
    var promotionPriceInput = document.getElementById('prd_promotion_price');

    if (value === '1') {
        promotionPriceSection.style.display = '';
        promotionPriceInput.disabled = false;
    } else {
        promotionPriceSection.style.display = 'none';
        promotionPriceInput.disabled = true;
        promotionPriceInput.value = ''; // Clear the value if not a promotion
    }
}
</script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="script.js"></script>

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

        if (boarddata.prd_price.value == "") {
            showError = 1;
            txtError = txtError + " ราคา";
        }

        if (boarddata.main_image.value == "") {
            showError = 1;
            txtError = txtError + " รูปภาพสินค้า (หลัก)";
        }
        // if (boarddata.additional_images.value == "") {
        //     showError = 1;
        //     txtError = txtError + " รูปภาพสินค้าหลายรูป";
        // }

        if (boarddata.pty_id.value == "") {
            showError = 1;
            txtError = txtError + " ประเภทสินค้า";
        }
        if (boarddata.prd_show.value == "") {
            showError = 1;
            txtError = txtError + " แสดงสินค้า";
        }
        if (boarddata.prd_reccom.value == "") {
            showError = 1;
            txtError = txtError + " สินค้าแนะนำ";
        }

        if (showError == 1) {
            alert(txtError);
            return false;
        }

        return true; // อนุญาตให้ฟอร์มส่งข้อมูลเมื่อข้อมูลถูกต้อง
    }

    function previewImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
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
   document.addEventListener('DOMContentLoaded', function () {
    const additionalImagesInput = document.getElementById('additional_images');
    const previewImagesDiv = document.getElementById('preview-images');

    additionalImagesInput.addEventListener('change', function () {
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

                    deleteButton.addEventListener('click', function () {
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
    document.addEventListener('DOMContentLoaded', function () {
        const mainImageInput = document.getElementById('main_image'); // เปลี่ยนชื่อตัวแปร
        const additionalImagesInput = document.getElementById('main_image');
        const previewImagesDiv = document.getElementById('preview-image');

        additionalImagesInput.addEventListener('change', function () {
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

                        deleteButton.addEventListener('click', function () {
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
    <?php if (isset($insert_success) && $insert_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ',
                text: 'เพิ่มข้อมูลเรียบร้อย!!',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '../product/';
            });
        </script>
    <?php endif; ?>

    <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>
    <?php include('../../web_stuc/end_script.php');?>

</body>

</html>