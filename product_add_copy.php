<?php
require_once('connect.php');

session_start();
// // ตรวจสอบว่าผู้ใช้มีค่า session admin ไม่เท่ากับหนึ่ง
// if (!isset($_SESSION['admin']) || $_SESSION['admin'] == 0) {
//     // ถ้าไม่มี session 'admin' หรือมีค่าไม่เท่ากับ 1
//     header("Location: /project-jarnsax"); // Redirect ไปยังหน้า index.php หรือหน้าอื่นที่คุณต้องการ
//     exit(); // จบการทำงานของสคริปต์
// }



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prd_name = $_POST["prd_name"];
    $prd_desc = $_POST["prd_desc"];
    $prd_price = $_POST["prd_price"];
    $pty_id = $_POST["pty_id"];
    $prd_show = $_POST["prd_show"];
    $prd_reccom = $_POST["prd_reccom"];

    // กำหนดโฟลเดอร์ที่จะใช้เก็บรูปภาพหลัก
    $targetDirectory = "uploads/";

    // ตรวจสอบว่าโฟลเดอร์ uploads มีอยู่หรือไม่ ถ้าไม่มีให้สร้าง
    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    // ตรวจสอบว่ามีการอัพโหลดรูปภาพหลักหรือไม่
    if (!empty($_FILES["main_image"]["tmp_name"])) {
        // กำหนดเส้นทางไฟล์รูปภาพหลัก
        $mainImgName = $_FILES["main_image"]["name"];
        $mainImgTmpName = $_FILES["main_image"]["tmp_name"];
        $mainImgTarget = $targetDirectory . basename($mainImgName);

        // อัพโหลดรูปภาพหลัก
        if (move_uploaded_file($mainImgTmpName, $mainImgTarget)) {
            // กำหนดเส้นทางไฟล์รูปภาพหลักให้กับฐานข้อมูล
            $mainImgPath = $mainImgTarget;
        } else {
            echo "ข้อผิดพลาดในการอัพโหลดไฟล์รูปภาพหลัก: " . $mainImgName;
            exit;
        }
    } else {
        echo "กรุณาเลือกไฟล์รูปภาพหลัก";
        exit;
    }

    // กำหนดคำสั่ง SQL เพื่อเพิ่มข้อมูลสินค้า
    $sql = "INSERT INTO product (prd_name, prd_desc,prd_price, pty_id, prd_show, prd_reccom, prd_img) 
            VALUES ('$prd_name', '$prd_desc','$prd_price', '$pty_id', '$prd_show', '$prd_reccom', '$mainImgPath')";

    if ($proj_connect->query($sql) === TRUE) {
        // รับค่า ID ของสินค้าที่เพิ่มล่าสุด
        $prd_id = $proj_connect->insert_id;

        // สร้างโฟลเดอร์ใหม่สำหรับรูปภาพของสินค้าโดยใช้ prd_id เป็นชื่อโฟลเดอร์
        $productImgDirectory = "product_img/$prd_id/";

        if (!file_exists($productImgDirectory)) {
            mkdir($productImgDirectory, 0777, true);
        }

        // ตรวจสอบว่ามีรูปภาพเพิ่มเติมหรือไม่
        if (!empty($_FILES["additional_images"]["tmp_name"])) {
            // อัพโหลดรูปภาพหลายรูปและบันทึกข้อมูลลงในตาราง product_img
            foreach ($_FILES["additional_images"]["tmp_name"] as $key => $tmp_name) {
                $img_name = $_FILES["additional_images"]["name"][$key];
                $img_tmp_name = $_FILES["additional_images"]["tmp_name"][$key];
                $img_target = $productImgDirectory . basename($img_name);

                if (move_uploaded_file($img_tmp_name, $img_target)) {
                    // เพิ่มข้อมูลลงในตาราง product_img
                    $sql = "INSERT INTO product_img (prd_id, img, img_show) 
                            VALUES ('$prd_id', '$img_target', '')";

                    if ($proj_connect->query($sql) !== TRUE) {
                        echo "ข้อผิดพลาดในการบันทึกข้อมูลรูปภาพ: " . $proj_connect->error;
                    }
                } else {
                    echo "ข้อผิดพลาดในการอัพโหลดไฟล์ $img_name.";
                }
            }
        }

        header("Location: product_show.php");
    } else {
        echo "ข้อผิดพลาดในการบันทึกข้อมูล: " . $proj_connect->error;
    }

    $proj_connect->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>เพิ่มสินค้า</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
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

<body>
    <div class="container">
        <h2>เพิ่มสินค้า</h2>
        <form action="" method="post" enctype="multipart/form-data" onSubmit="return chkdata(this);">
            <div class="mb-3">
                <label for="prd_name" class="form-label">ชื่อสินค้า:</label>
                <input type="text" name="prd_name" id="prd_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="prd_desc" class="form-label">รายละเอียดสินค้า:</label>
                <textarea name="prd_desc" id="prd_desc" rows="4" class="form-control"></textarea>
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
                <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*" >
                <div id="preview-image"></div>
            </div>
            <!-- แสดงรูปที่เลือก (ถ้ามี) -->
            <!-- <img id="imagePreview" src="#" alt="รูปภาพ" style="display: none; max-width: 300px; max-height: 300px;"> -->
            <div class="mb-3">
                <label for="additional_images" class="form-label">เลือกรูปภาพสินค้าเพิ่มเติม(เลือกได้หลายรูป):</label>
                <input type="file" name="additional_images[]" id="additional_images" class="form-control"
                    accept="image/*" multiple>
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
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prd_show" class="form-label">แสดงสินค้า:</label>
                <select id="prd_show" name="prd_show" class="form-control">
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" value="เพิ่มสินค้า" class="btn btn-primary">
            </div>
        </form>
    </div>


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
        if (boarddata.additional_images.value == "") {
            showError = 1;
            txtError = txtError + " รูปภาพสินค้าหลายรูป";
        }

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



</body>

</html>