<?php
$mmb_id = isset($_GET['mmb_id']) ? $_GET['mmb_id'] : null;

// เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อตามของคุณ)
require('connect/connect.php');

// ตรวจสอบการส่งค่า POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่าค่า 'mmb_addr' ถูกส่งมา
    if (isset($_POST['mmb_addr'])) {
        // ดึงค่าจากฟอร์ม
        $mmb_addr = $_POST['mmb_addr'];
        $mmb_name = isset($_POST['mmb_name']) ? $_POST['mmb_name'] : null;
        $mmb_surname = isset($_POST['mmb_surname']) ? $_POST['mmb_surname'] : null;
        $mmb_phone = isset($_POST['mmb_phone']) ? $_POST['mmb_phone'] : null;
        $mmb_email = isset($_POST['mmb_email']) ? $_POST['mmb_email'] : null;

        // ทำการ Update ข้อมูลลงในฟิลด์ mmb_addr และฟิลด์อื่นๆ ในตาราง member
        $update_query = "UPDATE member SET mmb_addr = '$mmb_addr', mmb_name = '$mmb_name', mmb_surname = '$mmb_surname', mmb_phone = '$mmb_phone', mmb_email = '$mmb_email' WHERE mmb_id = $mmb_id";
        $update_result = $proj_connect->query($update_query);

        if ($update_result) {
            // สำเร็จ
            echo "บันทึกข้อมูลสำเร็จ";
        } else {
            // ไม่สำเร็จ
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
        }
    }
}

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$user_query = "SELECT * FROM member WHERE mmb_id = $mmb_id";
$user_result = $proj_connect->query($user_query);

if ($user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
} else {
    // ไม่พบข้อมูลผู้ใช้
    echo "ไม่พบข้อมูลผู้ใช้";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('mainweb_page/head.php'); ?>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h2>เพิ่มข้อมูลใหม่</h2>
                <form action="address_add.php?mmb_id=<?php echo $mmb_id; ?>" method="POST">
                    <div class="mb-3">
                        <label for="mmb_name" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" name="mmb_name" required value="<?php echo $user_data['mmb_name']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mmb_surname" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" name="mmb_surname" required value="<?php echo $user_data['mmb_surname']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mmb_phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" name="mmb_phone" required value="<?php echo $user_data['mmb_phone']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mmb_email" class="form-label">อีเมล</label>
                        <input type="email" class="form-control" name="mmb_email" required value="<?php echo $user_data['mmb_email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mmb_addr" class="form-label">ที่อยู่</label>
                        <textarea class="form-control" rows="3" name="mmb_addr" required><?php echo $user_data['mmb_addr']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> บันทึกข้อมูล
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> กลับหน้าหลัก
                        </a>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('mainweb_page/end_script.php'); ?>
</body>

</html>
