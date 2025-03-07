<?php
// เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
require_once('../../../connect.php');

// ตรวจสอบว่าผู้ใช้มีค่า session admin ไม่เท่ากับหนึ่ง



?>

<?php
require_once('../../../connect/connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM product_type";
?>
<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('../../web_stuc/side_bar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('../../web_stuc/top_bar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <h1>Product Types</h1>
                <table id="myTable" class="table table-striped" style="width:100%">
        <tr>
            <th>ประเภทผลิตภัณฑ์</th>
            <th>รายละเอียด</th>
            <th>Product type show</th>
            <th colspan="2"><a href="product_type_add.php" class ="btn btn-primary">เพิ่มข้อมูล</a></th>
        </tr>

        <?php
        $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
        $totalrows_result = mysqli_num_rows($result);

        if ($totalrows_result > 0) {
            while ($row_result = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row_result['pty_name']; ?></td>
                    <td><?php echo $row_result['pty_desc']; ?></td>
                    <td><?php echo $row_result['pty_show'] == 1 ? 'Enable' : 'Disable'; ?></td>
                    <td><a href="product_type_edit.php?pty_id=<?php echo $row_result['pty_id']; ?>" class="btn btn-warning">แก้ไข</a></td>
                    <td><a onclick="confirmDelete(<?php echo  $row_result['pty_id']; ?>, '<?php echo  $row_result['pty_name']; ?>')" class="btn btn-danger">ลบ</a></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="4">ไม่มีข้อมูลในระบบ</td>
            </tr>
            <?php
        }
        ?>
    </table>



                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
                    crossorigin="anonymous">
                </script>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('../../web_stuc/footer.php');?>
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

    <script>
    function confirmDelete(pty_id, pty_name) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบข้อมูล "${pty_name}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`product_type_delete.php?pty_id=${pty_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                                // รีโหลดหน้าหลังจากลบสำเร็จ
                                if (data.success) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire('ลบไม่สำเร็จ', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ', error);
                        Swal.fire('ข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                    });
            }
        });
    }
</script>






<script>
$(document).ready(function() {
    $('.toggle-show, .toggle-reccom').change(function() {
        var prdId = $(this).data('prd-id');
        var column = $(this).hasClass('toggle-show') ? 'prd_show' : 'prd_reccom';
        var checked = this.checked ? 1 : 0;

        $.ajax({
            url: 'update_product.php', // เปลี่ยนเป็นชื่อไฟล์ที่คุณใช้เพื่ออัปเดตฐานข้อมูล
            method: 'POST',
            data: {
                prdId: prdId,
                column: column,
                checked: checked
            },
            success: function(response) {
                console.log('บันทึกสำเร็จ');
            },
            error: function() {
                console.log('เกิดข้อผิดพลาดในการบันทึก');
            }
        });
    });
});


</script>



    <!-- Bootstrap core JavaScript-->
    <?php include('../../web_stuc/end_script.php');?>



</body>

</html>