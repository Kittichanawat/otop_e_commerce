<?php

require_once('connect.php');
require_once('mainweb_page/condition.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prd_name = $_POST["prd_name"];
    $prd_desc = $_POST["prd_desc"];
    $pty_id = $_POST["pty_id"];
    $prd_show = $_POST["prd_show"];
    $prd_reccom = $_POST["prd_reccom"];
    $targetDirectory = "uploads/"; // สร้างโฟลเดอร์ uploads เพื่อเก็บรูปภาพ
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
//echo "--" . $targetFile;
$check = getimagesize($_FILES["image"]["tmp_name"]);


//echo "<br>--" . getimagesize($_FILES["imagee"]["tmp_name"]);



    // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    //echo "<br>--" . $check;
    if ($check === false) {
        echo "ไฟล์ไม่ใช่รูปภาพ.";
        $uploadOk = 0;
    }

    // ตรวจสอบว่าไฟล์มีอยู่แล้วหรือไม่
    if (file_exists($targetFile)) {
        echo "ขออภัย, ไฟล์นี้มีอยู่แล้ว.";
        $uploadOk = 0;
    }

    // ตรวจสอบขนาดไฟล์ (ในกรณีที่ต้องการกำหนดขนาดไฟล์สูงสุด)
    if ($_FILES["image"]["size"] > 500000) {
        echo "ขออภัย, ไฟล์มีขนาดใหญ่เกินไป.";
        $uploadOk = 0;
    }

    // ตรวจสอบประเภทของไฟล์ (ในกรณีที่ต้องการจำกัดประเภทไฟล์)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น.";
        $uploadOk = 0;
    }

    // ตรวจสอบว่า $uploadOk มีค่าเป็น 0 หรือไม่
    if ($uploadOk == 0) {
        echo "ขออภัย, ไม่สามารถอัพโหลดไฟล์ได้.";
    } else {
        // ถ้าทุกอย่างถูกต้อง ลบไฟล์เดิม (ถ้ามี) และอัพโหลดไฟล์ใหม่
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "ไฟล์ ". htmlspecialchars(basename($_FILES["image"]["name"])). " อัพโหลดเรียบร้อย.";

            // เพิ่มข้อมูลลงในฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
         

            $sql = "INSERT INTO product (prd_name, prd_desc, prd_img,pty_id, prd_show,prd_reccom) VALUES ('$prd_name', '$prd_desc', '$targetFile' , '$pty_id' , '$prd_show','$prd_reccom')";

            if ($proj_connect->query($sql) === TRUE) {
                header("Location: product_show.php");
            } else {
                echo "ข้อผิดพลาดในการบันทึกข้อมูล: " . $proj_connect->error;
            }

            $proj_connect->close();
        } else {
            echo "ข้อผิดพลาดในการอัพโหลดไฟล์.";
        }
    }
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

</head>

<body>

    <div class="container">
        <h2>เพิ่มสินค้า</h2>
        <form action="" method="post" enctype="multipart/form-data" onSubmit="return(chkdata(this));">
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
            <div class="mb-3">
                <label for="image" class="form-label">เลือกรูปภาพสินค้าหลัก:</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*"
                    onchange="previewImage(this)">
                    <!--<input type="file" name="imagee" id="imagee"> -->
            </div>
            <!-- แสดงรูปที่เลือก (ถ้ามี) -->
            <img id="imagePreview" src="#" alt="รูปภาพ" style="display: none; max-width: 300px; max-height: 300px;">
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
                <label for="prd_reccom" class="form-label">product_reccom:</label>
                <select id="prd_reccom" name="prd_reccom" class="form-control">
                    <option value="4">กรุณาเลือก</option>
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="prd_show" class="form-label">product_show:</label>
                <select id="prd_show" name="prd_show" class="form-control">
                    <option value="4">กรุณาเลือก</option>
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" value="เพิ่มสินค้า" class="btn btn-primary">
            </div>
        </form>
    </div>
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
            txtError = txtError + " ราคาสินค้า";
        }
        if (boarddata.image.value == "") {
            showError = 1;
            txtError = txtError + " รูปภาพ";
        }
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

        return true; // อนุญาตให้ฟอร์มส่งข้อมูลเมื่อข้อมูลถูกต้อง
    }
    </script>
    <script>
    // ฟังก์ชันเพื่อแสดงรูปภาพที่เลือก
    function previewImage(input) {
        var imagePreview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.style.display = 'block';
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.style.display = 'none';
            imagePreview.src = '#';
        }
    }
    </script>
</body>

</html>