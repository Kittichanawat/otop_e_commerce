<?php
require_once('../../connect.php');
require_once('../../mainweb_page/condition.php');

?>

<?php

$sql_script = "SELECT * FROM member ";
$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Buttons</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
     <style>
    /* กำหนดความกว้างของคอลัมน์ที่มีข้อความรายละเอียด */
    th:nth-child(3),
    td:nth-child(3) {
        max-width: 150px;
        /* ปรับขนาดของคอลัมน์รายละเอียด */
        white-space: nowrap;
        /* อักขระที่ยาวเกินจะไม่ขึ้นบรรทัดใหม่ */
        overflow: hidden;
        /* ซ่อนข้อความที่เกินขอบเขตของคอลัมน์ */
        text-overflow: ellipsis;
        /* แสดงเครื่องหมาย ... ถ้าข้อความยาวเกิน */
    }
    </style>
   

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
      <?php include('../web_stuc/side_bar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('../web_stuc/top_bar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
             

                <a href="index.php">หน้าหลัก</a>
    <h1 class=" text-center ">รายชื่อสมาชิก</h1>
    <table class="table table-bordered  border-dark">
    <thead>
        <tr>
            <th>ชื่อ-นามสกุล</th>
            <th>ชื่อผู้ใช้</th>
            <th>ที่อยู่</th>
            <th>เบอร์โทร</th>
            <th>Admin</th>
            <th>Member</th>
            <th>แสดง</th>
            <th colspan="2"><a href="member_add.php">เพิ่มข้อมูล</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($totalrows_result > 0) {
            while ($row_result = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row_result['mmb_name'] . ' ' . $row_result['mmb_surname']; ?></td>
                    <td><?php echo $row_result['mmb_username']; ?></td>
                    <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $row_result['mmb_addr']; ?></td>
                    <td><?php echo $row_result['mmb_phone']; ?></td>
                    <td><?php echo $row_result['status'] == "admin" ? 'ใช่' : 'ไม่ใช่'; ?></td>
                    <td><?php echo $row_result['member'] == 1 ? 'ใช่' : 'ไม่ใช่'; ?></td>
                    <td><?php echo $row_result['mmb_show'] == 1 ? 'แสดง' : 'ไม่แสดง'; ?></td>
                    <td>
                        <?php
                       if ($row_result['mmb_id'] == $_SESSION['mmb_id']) {
                        echo "คุณไม่สามารถแก้ไขตัวเองได้";
                        // สามารถเพิ่มการ Redirect หรือลิงก์ไปยังหน้าอื่นตามที่คุณต้องการ
                        // หรือแสดงข้อความแจ้งเตือนเพิ่มเติม
                       
                    }else {
                        if ($row_result['status'] == "admin") {
                            echo '';
                        } else {
                            echo '<a href="member_edit_admin.php?mmb_id=' . $row_result['mmb_id'] . '">แก้ไข</a>';
                        }
                    }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row_result['status'] == "admin") {
                            echo '';
                        } else {
                            echo '<a href="member_delete.php?mmb_id=' . $row_result['mmb_id'] . '">ลบ</a>';
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8">ไม่มีข้อมูลสมาชิกในระบบ</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>










    <!-- Add more product details as needed -->

   
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>