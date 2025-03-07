<?php
error_reporting(E_ALL);
date_default_timezone_set('Asia/Bangkok');
require_once('../authen.php'); // Include the database connection file

// Check if mmb_id is set
if (isset($_GET['mmb_id'])) {
    $mmb_id = $_GET['mmb_id'];

    // Create an instance of the Database class and connect to the database
    $Database = new Database();
    $conn = $Database->connect();

    // Query the database to fetch admin data
    $stmt = $conn->prepare("SELECT * FROM member WHERE mmb_id = :mmb_id");
    $stmt->bindParam(':mmb_id', $mmb_id, PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin) {
        echo "ไม่พบข้อมูลผู้ดูแลระบบ";
        exit;
    }
} else {
    echo "ไม่พบรหัสผู้ดูแลระบบที่ต้องการแก้ไข";
    exit;
}

// ตรวจสอบการส่งข้อมูลแบบ POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mmb_id = $_POST['mmb_id'];
    $mmb_name = $_POST['mmb_name'];
    $mmb_surname = $_POST['mmb_surname'];
    $mmb_username = $_POST['mmb_username'];
    $mmb_pwd = $_POST['mmb_pwd'];
    $status = $_POST['status'];
    $mmb_phone = $_POST['mmb_phone'];
    $mmb_email = $_POST['mmb_email'];

    // เชื่อมต่อฐานข้อมูล
    $Database = new Database();
    $conn = $Database->connect();

    // อัปเดตข้อมูลในฐานข้อมูล
    $update_stmt = $conn->prepare("UPDATE member SET mmb_name = :mmb_name, mmb_surname = :mmb_surname,mmb_username = :mmb_username,mmb_pwd = :mmb_pwd, status = :status, mmb_phone = :mmb_phone,mmb_email = :mmb_email WHERE mmb_id = :mmb_id");
    $update_stmt->bindParam(':mmb_name', $mmb_name, PDO::PARAM_STR);
    $update_stmt->bindParam(':mmb_surname', $mmb_surname, PDO::PARAM_STR);
    $update_stmt->bindParam(':mmb_username', $mmb_username, PDO::PARAM_STR);
    $update_stmt->bindParam(':mmb_pwd', $mmb_pwd, PDO::PARAM_STR);
    $update_stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $update_stmt->bindParam(':mmb_phone', $mmb_phone, PDO::PARAM_STR);
    $update_stmt->bindParam(':mmb_email', $mmb_email, PDO::PARAM_STR);
    $update_stmt->bindParam(':mmb_id', $mmb_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        // อัปเดตข้อมูลสำเร็จ
        echo "อัปเดตข้อมูลสำเร็จ";
    } else {
        // อัปเดตข้อมูลไม่สำเร็จ
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แก้ไขข้อมูลผู้ดูแลระบบ | AppzStory</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fas fa-user-cog"></i>
                                        แก้ไขข้อมูลผู้ดูแล
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData" method="POST" action="">
                                    <input type="hidden" name="mmb_id" value="<?php echo $admin['mmb_id']; ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="mmb_name">ชื่อจริง</label>
                                                    <input type="text" class="form-control" name="mmb_name"
                                                        id="mmb_name" placeholder="ชื่อจริง"
                                                        value="<?php echo htmlspecialchars($admin['mmb_name']); ?>"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mmb_surname">นามสกุล</label>
                                                    <input type="text" class="form-control" name="mmb_surname"
                                                        id="mmb_surname" placeholder="นามสกุล"
                                                        value="<?php echo htmlspecialchars($admin['mmb_surname']); ?>"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mmb_username">ชื่อผู้ใช้งาน</label>
                                                    <input type="text" class="form-control bg-light p-2 shadow-sm"
                                                        name="mmb_username" id="mmb_username"
                                                        value="<?php echo htmlspecialchars($admin['mmb_username']); ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="mmb_pwd">รหัสผ่าน</label>
                                                    <input type="password" class="form-control bg-light p-2 shadow-sm"
                                                        name="mmb_pwd" id="mmb_pwd"
                                                        value="<?php echo htmlspecialchars($admin['mmb_pwd']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                            <div class="form-group">
    <label for="permission">สิทธิ์การใช้งาน</label>
    <select class="form-control" name="status" id="permission" required>
        <option value="" <?php echo ($admin['status'] === "admin") ? 'selected' : ''; ?>></option>
        <option value="admin" <?php echo ($admin['status'] === "admin") ? 'selected' : ''; ?>>Admin</option>
        <?php
        if ($_SESSION['status'] === "superadmin") {
            echo '<option value="superadmin"';
            echo ($admin['status'] === "superadmin") ? ' selected' : '';
            echo '>Super Admin</option>';
        }
        ?>
    </select>
</div>

                                                <div class="form-group">
                                                    <label for="mmb_phone">เบอร์โทร</label>
                                                    <input type="tel" class="form-control" name="mmb_phone"
                                                        id="mmb_phone" placeholder="อีเมล"
                                                        value="<?php echo htmlspecialchars($admin['mmb_phone']); ?>"
                                                        required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mmb_email">อีเมล</label>
                                                    <input type="email" class="form-control" name="mmb_email"
                                                        id="mmb_email" placeholder="อีเมล"
                                                        value="<?php echo htmlspecialchars($admin['mmb_email']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50"
                                            name="submit">บันทึกข้อมูล</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <script>
    $(function() {
        $('#formData').submit(function(e) {
            e.preventDefault(); // ป้องกันการรีโหลดหน้าเว็บเมื่อ submit
            $.ajax({
                type: 'POST',
                url: $('#formData').attr('action'), // ใช้ URL จาก attribute "action" ของฟอร์ม
                data: $('#formData')
                    .serialize(), // รับข้อมูลจากฟอร์มและแปลงเป็นรูปแบบ URL-encoded
                success: function(response) {
                    // สำเร็จ
                    Swal.fire({
                        text: 'อัพเดตข้อมูลแอดมินเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign(
                            './'
                            ); // หลังจากกด "ตกลง" ให้ redirect ไปยังหน้าอื่น (ตามที่คุณต้องการ)
                    });
                },
                error: function() {
                    // เกิดข้อผิดพลาด
                    Swal.fire({
                        text: 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                }
            });
        });
    });
    </script>
    <script>
    // เมื่อค่าของสิทธิ์การใช้งานเปลี่ยนแปลง
    document.getElementById('permission').addEventListener('change', function() {
        // ดึงค่าที่เลือกในสิทธิ์การใช้งาน
        var selectedPermission = this.value;

        // เลือกตัวเลือก "Super Admin" โดย ID
        var superAdminOption = document.querySelector('select[name="status"] option[value="superadmin"]');

        if (selectedPermission === 'superadmin') {
            // ถ้าเลือก "Super Admin" ให้แสดงตัวเลือก "Super Admin"
            superAdminOption.style.display = 'block';
        } else {
            // ถ้าไม่เลือก "Super Admin" ให้ซ่อนตัวเลือก "Super Admin"
            superAdminOption.style.display = 'none';
        }
    });
    </script>
</body>

</html>