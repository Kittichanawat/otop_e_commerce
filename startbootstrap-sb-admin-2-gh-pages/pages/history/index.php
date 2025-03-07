
<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">
<?php
require_once('../../../connect/connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM history";
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

  

               
             
                <h1 class=" text-center ">หน้าจัดการประวัติ</h1>
           
                <!-- <p class="  ml-3">    select all <input type="checkbox" id="selectAll"></p>  -->
               
                <table id="myTable" class="table table-striped" style="width:100%">
        <thead>
          <tr>
           
            <th>ID</th>
            <th>หัวข้อ</th>
            <th>รายละเอียด</th>
            <th>รูป</th>
            <th>แสดงหน้าต่างๆ</th>
            <th>แก้ไข</th>
          
        
       
           


          
        
          </tr>
        </thead>
        <tbody>
        <?php
      require('../connectPDO/connnectpdo.php');
$stmt = $conn->query("SELECT * FROM history");
$stmt->execute();
  $hasRecords = false;
$members = $stmt->fetchAll();
foreach($members as $member) {
    $hasRecords = true;    

?>
<tr>
  
  <td><?php echo $member ['h_id']?></td>
  <td><?php echo $member ['h_title']?></td>
  <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $member ['h_detail']?></td>
  <td><img src="<?php echo $member ['h_img']?>" alt=""style="max-width: 100px; max-height: 100px;"></td>
  <td><?php echo $member['h_show'] == 1 ? 'Enable' : 'Disable'; ?></td>






  <td><a href="history_edit.php?h_id=<?php echo$member ['h_id'] ?>" class="btn btn-warning">แก้ไข</a></td>


</tr>

<?php
}
?>
<!-- <tfoot>
  <tr>
    <th>
     select all <input type="checkbox" id="selectAll">
    </th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</tfoot> -->
        </tbody>
      </table>
     
    
      
    <!-- <button type="submit" name="delete_records" class="btn btn-danger">Delete Selected</button> -->
    <?php if ($hasRecords) : ?>
    <a onclick="confirmDeleteSelect(<?php echo $member['h_id']; ?>)" name="delete_records" class="btn btn-danger">Delete Selected</a>
<?php endif; ?>





<script>
    function confirmDeleteSelect() {
        // Find all selected checkboxes
        const checkboxes = document.querySelectorAll('input[name="delete[]"]:checked');

        if (checkboxes.length === 0) {
            // No checkboxes selected, prevent form submission
            Swal.fire('No Items Selected', 'Please select the items you want to delete', 'error');
            return false;
        }

        Swal.fire({
            title: 'Confirm Deletion',
            text: `Are you sure you want to delete ${checkboxes.length} items?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms the deletion, proceed with the AJAX request
                deleteSelectedItems(checkboxes);
            } else {
                // If the user cancels the deletion, prevent form submission
                return false;
            }
        });
    }

    function deleteSelectedItems(checkboxes) {
        const hIds = Array.from(checkboxes).map(checkbox => checkbox.value);

        fetch('delete_records.php', {
            method: 'POST',
            body: JSON.stringify({ hIds: hIds }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deletion Successful', 'Items have been deleted successfully', 'success').then(() => {
                        // Reload the page or take any other necessary action
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Deletion Failed', 'An error occurred during deletion', 'error');
                }
            })
            .catch(error => {
                console.error('Error sending request:', error);
                Swal.fire('Error', 'Unable to delete items', 'error');
            });
    }
</script>


<!-- select all row script -->
<script>
  // Function to handle the "Select All" checkbox
  function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[name="delete[]"]');

    checkboxes.forEach((checkbox) => {
      checkbox.checked = selectAllCheckbox.checked;
    });
  }

  // Attach the event listener to the "Select All" checkbox
  const selectAllCheckbox = document.getElementById('selectAll');
  selectAllCheckbox.addEventListener('change', toggleSelectAll);
</script>

<!-- select all row script -->

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
    function confirmDelete(h_id, h_title) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบข้อมูล "${h_title}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`history_delete.php?h_id=${h_id}`)
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



<!-- <script>
    function confirmDelete(h_id, h_name) {
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล',
        text: `คุณต้องการลบข้อมูล "${h_name}" ใช่หรือไม่?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            // ถ้าผู้ใช้กดยืนยันการลบ
            window.location.href = `history_delete.php?h_id=${h_id}`;
        }
    });
}

</script> -->
<?php include('../../web_stuc/end_script.php');?>

</body>

</html>