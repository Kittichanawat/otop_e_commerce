<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">
    <?php
require_once('../../../connect/connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM page";
$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result = mysqli_num_rows($result);
?>


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

                <h1 class=" text-center ">หน้าจัดการหน้าต่างๆ</h1>
                <a href="pages_add.php" class="text-left mb-3 ml-3 btn btn-primary" >เพิ่มหน้าต่างๆ </a>
                 <table id="myTable" class="table table-striped" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>หัวข้อ</th>
            <th>รายละเอียด</th>
            <th>รูป</th>
            <th>แสดงหน้าต่างๆ</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
       
           


          
        
          </tr>
        </thead>
        <tbody>
        <?php
      require('../connectPDO/connnectpdo.php');
$stmt = $conn->query("SELECT * FROM page");
$stmt->execute();

$members = $stmt->fetchAll();
foreach($members as $member) {


?>
<tr>
  <td><?php echo $member ['id']?></td>
  <td><?php echo $member ['title']?></td>
  <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $member ['detail']?></td>
  <td><img src="<?php echo $member ['img']?>" alt=""style="max-width: 100px; max-height: 100px;"></td>
  <td><?php echo $member['pages_show'] == 1 ? 'Enable' : 'Disable'; ?></td>






  <td><a href="pages_edit.php?id=<?php echo$member ['id'] ?>" class="btn btn-warning">แก้ไข</a></td>
  <td><a onclick="confirmDelete(<?php echo  $member['id']; ?>, '<?php echo  $member['title']; ?>')" class="btn btn-danger">ลบ</a></td>

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
    function confirmDelete(id, title) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบข้อมูล "${title}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`pages_delete.php?id=${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                                // รีโหลดหน้าหลังจากลบสำเร็จ
                                window.location.reload();
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
    <?php include('../../web_stuc/end_script.php');?>

</body>

</html>