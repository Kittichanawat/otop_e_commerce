<?php
require_once('connect.php');

// ตรวจสอบว่ามีการรับค่า id สินค้าที่ต้องการแก้ไข
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

    // ค้นหาข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT * FROM tourist WHERE p_id = '$p_id'";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $p_name = $row['p_name'];
        $p_des = $row['p_des'];
        $p_addr = $row['p_addr'];
        $p_img = $row['p_img'];
    } else {
        // ถ้าไม่พบสินค้าที่ต้องการแก้ไขในฐานข้อมูล
        echo "ไม่พบสินค้าที่ต้องการแก้ไข";
        exit;
    }
} else {
    // ถ้าไม่มีการรับค่า id สินค้า
    echo "ไม่ระบุรหัสสินค้าที่ต้องการแก้ไข";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าข้อมูลที่แก้ไขจากฟอร์ม
    $new_p_name = $_POST["p_name"];
    $new_p_des = $_POST["p_des"];
    $new_p_addr = $_POST["p_addr"];



    
    // ตรวจสอบว่ามีการเลือกไฟล์รูปภาพใหม่หรือไม่
    if ($_FILES["new_image"]["name"]) {
        // รับค่าไฟล์รูปภาพใหม่
        $new_image = $_FILES["new_image"];
        $targetDirectory = "uploads/"; // สร้างโฟลเดอร์ uploads เพื่อเก็บรูปภาพใหม่
        $targetFile = $targetDirectory . basename($new_image["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // ตรวจสอบว่าไฟล์เป็นรูปภาพหรือไม่
        $check = getimagesize($new_image["tmp_name"]);
        if ($check === false) {
            echo "ไฟล์ไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }

        // ตรวจสอบขนาดไฟล์ (ในกรณีที่ต้องการกำหนดขนาดไฟล์สูงสุด)
        if ($new_image["size"] > 500000) {
            echo "ขออภัย, ไฟล์มีขนาดใหญ่เกินไป.";
            $uploadOk = 0;
        }

        // ตรวจสอบประเภทของไฟล์ (ในกรณีที่ต้องการจำกัดประเภทไฟล์)
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "ขออภัย, สามารถอัพโหลดได้เฉพาะไฟล์ JPG, JPEG, PNG และ GIF เท่านั้น.";
            $uploadOk = 0;
        }

        // ตรวจสอบว่า $uploadOk มีค่าเป็น 0 หรือไม่
        if ($uploadOk == 0) {
            echo "ขออภัย, ไม่สามารถอัพโหลดไฟล์ได้.";
        } else {
            // ถ้าทุกอย่างถูกต้อง ลบไฟล์เดิม (ถ้ามี) และอัพโหลดไฟล์ใหม่
            if (move_uploaded_file($new_image["tmp_name"], $targetFile)) {
                echo "ไฟล์ ". htmlspecialchars(basename($new_image["name"])). " อัพโหลดเรียบร้อย.";

                // ลบไฟล์รูปเก่า (ถ้ามี)
                if (file_exists($p_img)) {
                    unlink($p_img);
                }

                // อัพเดทข้อมูลในฐานข้อมูล
                $update_sql = "UPDATE tourist SET p_name = '$new_p_name', p_des = '$new_p_des', p_img = '$targetFile',p_addr= '$new_p_addr' WHERE p_id = '$p_id'";
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
        // ถ้าไม่มีการเลือกไฟล์รูปภาพใหม่
        // อัพเดทข้อมูลในฐานข้อมูลโดยไม่เปลี่ยนรูปภาพ
        $update_sql = "UPDATE tourist SET p_name = '$new_p_name', p_des = '$new_p_des', p_addr= '$new_p_addr' WHERE p_id = '$p_id'";
        
        if ($proj_connect->query($update_sql) === TRUE) {
            header("Location: tourist_show.php");
        } else {
            echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>แก้ไขสินค้า</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <h2>แก้ไขสินค้า</h2>
    <form action="" method="post" enctype="multipart/form-data" onSubmit="return(chkdata(this));">
        <div class="mb-3">
            <label for="p_name" class="form-label">ชื่อ:</label>
            <input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo $p_name; ?>" >
        </div>
        <div class="mb-3">
            <label for="p_des" class="form-label">รายละเอียด:</label>
            <textarea name="p_des" id="p_des" rows="4" class="form-control" required><?php echo $p_des; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="p_addr" class="form-label">ที่อยู่:</label>
            <input type="text" name="p_addr" id="p_addr" class="form-control" value="<?php echo $p_addr; ?>"   min="1">
        </div>
        <div class="mb-3">
            <label for="new_image" class="form-label">เลือกรูปภาพใหม่ (ถ้าต้องการเปลี่ยน):</label>
            <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*" onchange="previewImage(this)">
        </div>
        <!-- แสดงรูปภาพปัจจุบัน -->
        <div class="mb-3">
            <label for="current_image" class="form-label">รูปภาพปัจจุบัน:</label>
            <img id="current_image" src="<?php echo $p_img; ?>" alt="รูปภาพปัจจุบัน" style="max-width: 300px; max-height: 300px;">
        </div>
        <!-- แสดงรูปที่เลือก (ถ้ามี) -->
        <div class="mb-3">
            <label for="imagePreview" class="form-label">รูปตัวอย่าง (ถ้ามีการเปลี่ยน):</label>
            <img id="imagePreview" src="#" alt="รูปตัวอย่าง" style="display: none; max-width: 300px; max-height: 300px;">
        </div>

      
        <div class="mb-3">
            <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
        </div>
    </form>
</div>

<script>
    // ฟังก์ชันเพื่อแสดงรูปภาพที่เลือก
    function previewImage(input) {
        var imagePreview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
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
      if (boarddata.prd_img.value == "") {
        showError = 1;
        txtError = txtError + " รูป";
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
</body>
</html>