<?php
session_start();
require_once('../../../php-line-login-main/LineLogin.php');
require_once('../../../login-with-google-account2/login.php');
?>
<?php
/**
 * Login Page
 *
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */

require_once('../../../connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล




// ตรวจสอบว่ามีการส่งข้อมูล POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mmb_username = $_POST["mmb_username"];
    $mmb_pwd = $_POST["mmb_pwd"];

    if (empty($mmb_username) || empty($mmb_pwd)) {
        // ถ้าชื่อผู้ใช้หรือรหัสผ่านว่างเปล่าให้แสดงข้อความ
        $error_message = "กรุณากรอกชื่อผู้ใช้และรหัสผ่าน";
    } else {
        // ตรวจสอบชื่อผู้ใช้และรหัสผ่าน
        $query = "SELECT * FROM member WHERE mmb_username = ?";
        $stmt = mysqli_prepare($proj_connect, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $mmb_username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                // การตรวจสอบสำเร็จ
                $row = mysqli_fetch_assoc($result);
                
                if (password_verify($mmb_pwd, $row['mmb_pwd'])) {
                    // การตรวจสอบรหัสผ่านและ hashed password สำเร็จ
                    if ($row['mmb_show'] == 0) {
                        // ถ้า mmb_show เป็น 0 คือบัญชีถูกระงับ
                        $error_message = "บัญชีผู้ใช้ของคุณถูกระงับชั่วคราว กรุณาติดต่อผู้ดูแลระบบ";
                    } else {
                        // เก็บรหัสสมาชิกและบทบาทในตัวแปรเซสชัน
                        $_SESSION['mmb_id'] = $row['mmb_id'];
                        $_SESSION['mmb_username'] = $row['mmb_username'];
                        $_SESSION['mmb_name'] = $row['mmb_name'];
                        $_SESSION['mmb_surname'] = $row['mmb_surname'];
                        $_SESSION['status'] = $row['status'];
                        $_SESSION['member'] = $row['member'];

                        if (isset($_SESSION['status']) && ($_SESSION['status'] == "admin" || $_SESSION['status'] == "superadmin")) {
                            // เข้าสู่ระบบสำเร็จ และมีบทบาทเป็น "admin" หรือ "superadmin"
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
                                    window.location.href = '../startbootstrap-sb-admin-2-gh-pages/pages/dashboard/'; // นำไปยังหน้าหลักของผู้ใช้ทั้ง "admin" และ "superadmin"
                                });
                            </script>
                            <?php 
                        } elseif (isset($_SESSION['status']) && $_SESSION['status'] == "" && $_SESSION['member'] == 1) {
                            // สมาชิกมี status ว่างและ member เท่ากับ 1
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
                                    window.location.href = '../index.php'; // นำไปยังหน้าหลัก
                                });
                            </script>
                            <?php 
                        }
                    }
                } else {
                    // การตรวจสอบล้มเหลว
                    $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
                }
            } else {
                // ไม่พบชื่อผู้ใช้
                $error_message = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            }

            mysqli_stmt_close($stmt);
        } else {
            // การเตรียมคำสั่ง SQL ล้มเหลว
            // ทำการจัดการข้อผิดพลาดตามที่คุณต้องการ
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }

        /* Custom style for Line Login Button */
        .btn-line {
            background-color: #00B900;
            color: #fff;
        }

        .btn-line:hover {
            background-color: #05a946;
        }
    </style>
</head>
<body>


<script>
    $(document).ready(function () {
        $("#yourFormId").validate({
            rules: {
              
             
             
                pty_name: {
                    required: true,
                    
                },
               pty_desc: {
                    required: true,
                   
                }
               
                
            },
            messages: {
           
                pty_name: {
                    required: 'โปรดกรอกข้อมูล ชื่อผู้ใช้',
                 
                },
                pty_desc: {
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
        <h1>Edit Product Type Information</h1>
        <form id="yourFormId" method="POST" >
            <div class="mb-3">
                <label for="pty_name" class="form-label">ชื่อประเภทผลิตภัณฑ์:</label>
                <input type="text" class="form-control" name="pty_name"id="pty_name" >
            </div>

            <div class="mb-3">
                <label for="pty_desc" class="form-label">รายละเอียด:</label>
                <input type="text" class="form-control" name="pty_desc" id="pty_desc">
            </div>

            <div class="mb-3">
                <label for="pty_show" class="form-label">แสดงผล:</label>
                <select class="form-select" name="pty_show">
                    <option value="0" >ไม่แสดง</option>
                    <option value="1" >แสดง</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="../product_type/" class="btn btn-secondary" role="button">Cancel</a>
        </form>
    </div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<!-- Your custom JavaScript -->




















 <!-- Bootstrap core JavaScript-->

    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>
    

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>

    <script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

            </script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<!-- jQuery Validation Plugin -->


<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
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
                        window.location.href = '../../web_stuc/logout.php';
                    }
                })
            }
            </script>
<script>
    function lineLogin() {
        // Add your Line login logic here
        alert('Login with Line clicked');
    }

    document.getElementById('normalLoginForm').addEventListener('submit', function (event) {
        event.preventDefault();
        // Add your normal login logic here
        alert('Normal login clicked');
    });
</script>

</body>
</html>
