
<?php



// ต่อไปเราสามารถใช้ $mmb_username เพื่อแสดงชื่อผู้ใช้ในหน้าเว็บของคุณได้
?>
<!DOCTYPE html>
<html>

<!-- head -->
<?php include ('mainweb_page/head.php');

?>
<!-- head -->

<body>
 
<?php include('mainweb_page/nav_bar.php');?>


<?php
require_once('connect.php');




// Check if the member ID is provided in the query string
if (isset($_GET['mmb_id'])) {
    $mmb_id = $_GET['mmb_id'];

    // Search for member data in the database
    $sql = "SELECT * FROM member WHERE mmb_id = '$mmb_id'";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mmb_name = $row['mmb_name'];
        $mmb_surname = $row['mmb_surname'];
        $mmb_username = $row['mmb_username'];
        $mmb_pwd = $row['mmb_pwd'];
        $mmb_addr = $row['mmb_addr'];
        $mmb_phone = $row['mmb_phone'];
        $status = $row['status'];
        $mmb_show = $row['mmb_show'];
    } else {
        // If the member to edit is not found in the database
        echo "ไม่พบข้อมูลสมาชิกที่ต้องการแก้ไข";
        exit;
    }
} else {
    // If the member ID is not provided in the query string
    echo "ไม่ระบุรหัสสมาชิกที่ต้องการแก้ไข";
    exit;
}

// ตรวจสอบว่า username ไม่ซ้ำกัน
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receive data from the form
    $new_mmb_username = $_POST["mmb_username"];

    // Check if the new username already exists in the database
    $check_username_sql = "SELECT * FROM member WHERE mmb_username = '$new_mmb_username' AND mmb_id != '$mmb_id'";
    $check_result = $proj_connect->query($check_username_sql);

    if ($check_result->num_rows > 0) {
        // ถ้ามี username นี้อยู่แล้วในฐานข้อมูล
       $username_fail = true;
    } else {
        // ถ้า username ไม่ซ้ำกัน สามารถทำการอัปเดตข้อมูลได้
        $new_mmb_name = $_POST["mmb_name"];
        $new_mmb_surname = $_POST["mmb_surname"];
        $new_mmb_pwd = $_POST["mmb_pwd"];
        $new_mmb_addr = $_POST["mmb_addr"];
        $new_mmb_phone = $_POST["mmb_phone"];
        $confirm_password = $_POST["confirm_password"]; // Old password (confirm)

        // Check if the old password matches the current password
        if ($confirm_password != $mmb_pwd) {
            echo "รหัสผ่านเดิมไม่ถูกต้อง";
        } else {
            // Check if the user has permission to change the admin status
           
                // Update the data in the database
                $update_sql = "UPDATE member SET mmb_name = '$new_mmb_name', mmb_surname = '$new_mmb_surname', mmb_username = '$new_mmb_username', mmb_pwd = '$new_mmb_pwd', mmb_addr = '$new_mmb_addr', mmb_phone = '$new_mmb_phone' WHERE mmb_id = '$mmb_id'";
                
                if ($proj_connect->query($update_sql) === TRUE) {
                    $edit_success = true;
                } else {
                    echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
                }
            
        }
    }
}

?>


    <div class="container">
        <h2>แก้ไขข้อมูลสมาชิก</h2>
        <form action="" method="post" onSubmit="return chkdata(this);">
            <div class="mb-3">
                <label for="mmb_name" class="form-label">ชื่อ:</label>
                <input type="text" name="mmb_name" id="mmb_name" class="form-control"
                    value="<?php echo $mmb_name; ?>">
            </div>
            <div class="mb-3">
                <label for="mmb_surname" class="form-label">นามสกุล:</label>
                <input type="text" name="mmb_surname" id="mmb_surname" class="form-control"
                    value="<?php echo $mmb_surname; ?>">
            </div>
            <div class="mb-3">
                <label for="mmb_username" class="form-label">Username:</label>
                <input type="text" name="mmb_username" id="mmb_username" class="form-control"
                    value="<?php echo $mmb_username; ?>">
            </div>
            <div class="mb-3">
                <label for="mmb_pwd" class="form-label">Password:</label>
                <input type="password" name="mmb_pwd" id="mmb_pwd" class="form-control"
                    value="">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">กรุณายืนยันรหัสผ่านเดิม(เพื่อทำการแก้ไขข้อมูล):</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                    required>
            </div>
            <div class="mb-3">
                <label for="mmb_addr" class="form-label">ที่อยู่:</label>
                <textarea name="mmb_addr" id="mmb_addr" rows="4" class="form-control"
                    required><?php echo $mmb_addr; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="mmb_phone" class="form-label">เบอร์โทร:</label>
                <input type="tel" name="mmb_phone" id="mmb_phone" class="form-control"
                    value="<?php echo $mmb_phone; ?>">
            </div>
        
            <!-- <div class="mb-3">
                <label for="mmb_show" class="form-label">แสดงข้อมูล:</label>
                <select id="mmb_show" name="mmb_show" class="form-control">
                    <option value="1" <?php if ($mmb_show == 1) echo "selected"; ?>>แสดง</option>
                    <option value="0" <?php if ($mmb_show == 0) echo "selected"; ?>>ไม่แสดง</option>
                </select>
            </div> -->
            <div class="mb-3">
                <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">    <a href="../member/" class="btn btn-primary">ยกเลิก</a>
            </div>
            <div class="mb-3">
            
            </div>
        </form>
    </div>
    <?php if (isset($username_fail) && $username_fail) : ?>
        <script>
        Swal.fire({
            icon: "error",
            title: "ขออภัย!",
            text: "Username นี้ถูกใช้แล้ว โปรดเลือก username อื่น",
            showConfirmButton: true // เปลี่ยนเป็น true เพื่อให้มีปุ่ม OK
        });
    </script>
    <?php endif; ?>
    <?php if (isset($edit_fail) && $edit_fail) : ?>
        <script>
        Swal.fire({
            icon: "error",
            title: "ขออภัย!",
            text: "คุณไม่มีสิทธิ์เปลี่ยนระดับเป็นแอดมิน",
            showConfirmButton: true // เปลี่ยนเป็น true เพื่อให้มีปุ่ม OK
        });
    </script>
    <?php endif; ?>
    <?php if (isset($edit_success) && $edit_success) : ?>
        <script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "สำเร็จ!",
                    text: "แก้ไขข้อมูลผู้ใช้เรียบร้อย",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "/project-jarnsax"; // นำแอดมินไปยังหน้า product_show.php
                });
            </script>
 
    <?php endif; ?>

    <?php include('mainweb_page/end_script.php');?>
</body>

</html>
