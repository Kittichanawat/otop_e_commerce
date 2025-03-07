<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>AppzStory Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
/**
 * Login Page
 *
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */

require_once('../connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล

session_start();

if (isset($_SESSION['mmb_username'])) {
  // ถ้ามีเซสชันที่มี mmb_username อยู่แล้ว
  // คุณสามารถ redirect ไปยังหน้าอื่นหรือทำการแจ้งเตือนตามที่คุณต้องการ
  // ตัวอย่างเช่น
  header("Location: ../");
  exit;
}

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


<header class="bg"></header>
<section class="d-flex align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <section class="col-lg-6">
        <div class="card shadow p-3 p-md-4">
          <h1 class="text-center text-primary font-weight-bold">OTOP จังหวัดเชียงราย</h1>
          <h4 class="text-center">เข้าสู่ระบบ</h4> 
          <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
          <div class="card-body">
            <!-- HTML Form Login --> 
            <form id="formLogin" method="POST">
              <div class="form-group col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text px-2">ชื่อผู้ใช้งาน</div>
                  </div>
                  <input type="text" class="form-control" name="mmb_username"  id="mmb_username"placeholder="username" >
                </div>
              </div>
              <div class="form-group col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text px-3">รหัสผ่าน</div>
                  </div>
                  <input type="password" class="form-control" name="mmb_pwd"id="mmb_pwd" placeholder="password" >
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block"> เข้าสู่ระบบ</button>
              <a href="../" class ="btn btn-danger btn-block">กลับหน้าหลัก</a>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>
<!-- <script>
  $(function() {
    /** Ajax Submit Login */
    $("#formLogin").submit(function(e){
      e.preventDefault()
      $.ajax({
        type: "POST",
        url: "service/auth/login.php",
        data: $(this).serialize()
      }).done(function(resp) {
        toastr.success('เข้าสู่ระบบเรียบร้อย')
        setTimeout(() => {
          location.href = 'pages/dashboard/'
        }, 800)
      }).fail(function(resp) {
        toastr.error('ไม่สามารถเข้าสู่ระบบได้')
      })
    })
  })
</script> -->
<!-- script -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>

</body>
</html>