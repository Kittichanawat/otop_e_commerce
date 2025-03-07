<?php
require_once('../authen.php'); // ตรวจสอบการเข้าสู่ระบบ
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูลผู้ดูแลระบบ | AppzStory</title>
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
                                    เพิ่มข้อมูลผู้ดูแล
                                </h4>
                                <a href="./" class="btn btn-info my-3 ">
                                    <i class="fas fa-list"></i>
                                    กลับหน้าหลัก
                                </a>
                            </div>
                            <form id="formData">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 px-1 px-md-5">
                                            <div class="form-group">
                                                <label for="mmb_name">ชื่อจริง</label>
                                                <input type="text" class="form-control" name="mmb_name" id="mmb_name" placeholder="ชื่อจริง" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="mmb_surname">นามสกุล</label>
                                                <input type="text" class="form-control" name="mmb_surname" id="mmb_surname" placeholder="นามสกุล" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="mmb_username">ชื่อผู้ใช้งาน</label>
                                                <input type="text" class="form-control" name="mmb_username" id="mmb_username" placeholder="ชื่อผู้ใช้งาน" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="mmb_pwd">รหัสผ่าน</label>
                                                <input type="password" class="form-control" name="mmb_pwd" id="mmb_pwd" placeholder="รหัสผ่าน" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 px-1 px-md-5">
                                            <div class="form-group">
                                                <label for="status">สิทธิ์การใช้งาน</label>
                                                <select class="form-control" name="status" id="status" required>
                                                    <option value="" disabled selected>เลือกสิทธิ์การใช้งาน</option>
                                                    <option value="superadmin">Super Admin</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="mmb_phone">เบอร์โทร</label>
                                                <input type="tel" class="form-control" name="mmb_phone" id="mmb_phone" placeholder="เบอร์โทร" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="mmb_addr">ที่อยู่</label>
                                                <textarea id="mmb_addr" class="form-control" name="mmb_addr"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="mmb_email">อีเมล</label>
                                                <input type="email" class="form-control" name="mmb_email" id="mmb_email" placeholder="อีเมล" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
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
        $('#formData').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../../service/manager/create.php', // แก้ไข URL ตามที่คุณต้องการ
                data: $('#formData').serialize()
            }).done(function(resp) {
                Swal.fire({
                    text: 'เพิ่มข้อมูลเรียบร้อย',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                }).then((result) => {
                    location.assign('./');
                });
            });
        });
    });
</script>
</body>
</html>
