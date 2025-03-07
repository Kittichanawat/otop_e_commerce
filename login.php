<!DOCTYPE html>
<html lang="en">

<?php include ('mainweb_page/head.php');?>

<body>
    <?php
require_once('connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
session_start();

// ตรวจสอบว่ามีการส่งข้อมูล POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mmb_username = $_POST["mmb_username"];
    $mmb_pwd = $_POST["mmb_pwd"];

    // ตรวจสอบว่า checkbox "จดจำฉัน" ถูกเลือกหรือไม่
    if (isset($_POST["remember_me"])) {
        // ถ้าถูกเลือก สร้างคุกกี้เพื่อจดจำข้อมูลผู้ใช้
        setcookie("remembered_username", $mmb_username, time() + 3600 * 24 * 30); // เก็บชื่อผู้ใช้ลงในคุกกี้
        setcookie("remembered_pwd", $mmb_pwd, time() + 3600 * 24 * 30); // เก็บรหัสผ่านลงในคุกกี้
    }


    // คิวรี่เพื่อตรวจสอบว่าชื่อผู้ใช้และรหัสผ่านที่ให้มีอยู่ในฐานข้อมูลหรือไม่
    $query = "SELECT * FROM member WHERE mmb_username = '$mmb_username' AND mmb_pwd = '$mmb_pwd'";
    $result = mysqli_query($proj_connect, $query);

    if (mysqli_num_rows($result) == 1) {
        // การตรวจสอบสำเร็จ
        $row = mysqli_fetch_assoc($result);

        // เก็บรหัสสมาชิกและบทบาทในตัวแปรเซสชัน
        $_SESSION['mmb_id'] = $row['mmb_id'];
        $_SESSION['mmb_username'] = $row['mmb_username'];
        $_SESSION['member'] = $row['member'];
        $_SESSION['status'] = $row['status'];

        if ($_SESSION["admin"] == "1") {  // ตรวจสอบว่าผู้ใช้เป็นแอดมินหรือไม่
            ?>

    <script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'เข้าสู่ระบบสำเร็จ',
        text: 'ยินดีต้อนรับคุณ <?php echo $_SESSION['mmb_username']; ?>',
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        window.location.href = 'index.php'; // นำแอดมินไปยังหน้า product_show.php
    });
    </script>
    <?php
        } else if ($_SESSION["member"] == "1") {  // ตรวจสอบว่าผู้ใช้เป็นสมาชิกหรือไม่
            ?>

    <script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'เข้าสู่ระบบสำเร็จ',
        text: 'ยินดีต้อนรับคุณ <?php echo $_SESSION['mmb_username']; ?>',
        showConfirmButton: false,
        timer: 1500
    }).then(() => {
        window.location.href = 'index.php'; // นำสมาชิกไปยังหน้า index.php
    });
    </script>
    <?php
        }

    } else {
        // การตรวจสอบล้มเหลว
        $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $("#yourFormId").validate({
            rules: {
              
             
             
                mmb_username: {
                    required: true,
                    
                },
                mmb_pwd: {
                    required: true,
                   
                }
               
                
            },
            messages: {
           
                mmb_username: {
                    required: 'โปรดกรอกข้อมูล ชื่อผู้ใช้',
                 
                },
                mmb_pwd: {
                    required: 'โปรดกรอกรหัสผ่าน',
                
                }
             
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // เพิ่มกฎสำหรับตรวจสอบรหัสผ่านที่แข็งแกร่ง
        $.validator.addMethod('strongPassword', function (value, element) {
            return this.optional(element) ||
                value.length >= 6 &&
                /\d/.test(value) &&
                /[a-z]/i.test(value);
        }, 'รหัสผ่านควรมีอย่างน้อย 6 ตัว, ประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก');

        // เพิ่มกฎสำหรับตรวจสอบชื่อผู้ใช้ที่ประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น
        $.validator.addMethod('alphanumeric', function (value, element) {
    return this.optional(element) || /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]+$/.test(value);
}, 'ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลข');
    });
</script>

  <div class="container">
    <h1 class="mt-5">เข้าสู่ระบบสมาชิก</h1>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form id="yourFormId" action="" method="POST" >
        <div class="mb-3">
            <label for="mmb_username" class="form-label">ชื่อผู้ใช้:</label>
            <input type="text" class="form-control" id="mmb_username" name="mmb_username" required
                   value="<?php echo isset($_COOKIE['remembered_username']) ? $_COOKIE['remembered_username'] : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="mmb_pwd" class="form-label">รหัสผ่าน:</label>
            <input type="password" class="form-control" id="mmb_pwd" name="mmb_pwd" required
                   value="<?php echo isset($_COOKIE['remembered_pwd']) ? $_COOKIE['remembered_pwd'] : ''; ?>">
        </div>
        <div class="mb-3">
            <input type="checkbox" id="remember_me" name="remember_me" value="1"
                   <?php echo isset($_COOKIE['remembered_username']) ? 'checked' : ''; ?>>
            <label for="remember_me">จดจำฉัน</label>
        </div>
        <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
    </form>
</div>

    <!-- function logout -->
    <script>
    function logout() {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ออกจากระบบสำเร็จ',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            if (result) {
                window.location.href = 'logout.php';
            }
        })
    }
    </script>
    <?php include ('mainweb_page/end_script.php.php');?>
</body>

</html>