<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">
    <?php
require_once('../../../connect/connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM banner";
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

                <h1 class=" text-center ">หน้าจัดการbanner</h1>
                <a href="banner_add.php" class="text-left mb-3 ml-3 btn btn-primary" >เพิ่มbanner </a>
                <table id="studentTable" class="table table-striped" style="width:100%">
        <thead>
        <tr>
   
               
                <th>ลำดับ</th>
                <th>Name</th>
                <th>Age</th>
                <th>Grade</th>
                <th>Order column</th>
                <th>แก้ไข</th>
            <th>ลบ</th>
           
            </tr>
        </thead>
        <tbody>
            <?php
                require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
                $stmt = $conn->query("SELECT * FROM banner ORDER BY order_column ASC");
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $i = 1; // เริ่มต้นลำดับที่ 1
                foreach ($students as $student) {
                    ?>
                <tr data-id="<?php echo $student['id']; ?>">
               
                <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
  <td><?php echo $student ['title']?></td>
  <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $student ['detail']?></td>
  <td><img src="<?php echo $student ['img']?>" alt=""style="max-width: 100px; max-height: 100px;"></td>
  <td><?php echo $student ['order_column']?></td>
  <td><a href="banner_edit.php?id=<?php echo$student ['id'] ?>" class="btn btn-warning">แก้ไข</a></td>
  <td><a onclick="confirmDelete(<?php echo  $student['id']; ?>, '<?php echo  $student['title']; ?>')" class="btn btn-danger">ลบ</a></td>


                    </tr>
                    <?php
}
?>
        </tbody>
      </table>


    


    <script>
  $(document).ready(function() {
    var table = $('#studentTable').DataTable({
        rowReorder: {
            dataSrc: 'order_column', // กำหนด dataSrc เป็นชื่อคอลัมน์
            selector: 'tr', // หรือเลือกตามที่จำเป็น
            update: false
        },
        order: [[4, 'asc']], // กำหนดให้เรียงลำดับตามคอลัมน์ 'order_column'
        columnDefs: [{
            targets: [4], // อ้างอิงถึงคอลัมน์ 'order_column' ที่คุณไม่ต้องการแสดง
            visible: false, // ซ่อนคอลัมน์นี้
            searchable: false
        }]
    });
     table.on('row-reorder', function(e, diff, edit) {
        for (var i = 0, ien = diff.length; i < ien; i++) {
            // ใช้ diff[i].newData เพื่อเข้าถึงลำดับใหม่
            $(table.row(diff[i].node).node()).find('td:first').html(diff[i].newPosition + 1);
        }
    });
    table.on('row-reorder', function (e, details, changes) {
    var updates = details.map(function(diff) {
        var row = $(table.row(diff.node).node());
        var id = row.data('id'); // เข้าถึง data-id attribute
        var newOrder = diff.newPosition + 1;

        return {
            id: id,
            newOrder: newOrder
        };
    });

    if (updates.length) {
        $.ajax({
            url: 'update_order_column.php',
            type: 'POST',
            data: JSON.stringify({updates: updates}),
            contentType: 'application/json',
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
});
});

    </script>





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
                fetch(`banner_delete.php?id=${id}`)
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
        const Ids = Array.from(checkboxes).map(checkbox => checkbox.value);

        fetch('delete_records.php', {
            method: 'POST',
            body: JSON.stringify({ Ids: Ids }),
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















    <?php include('../../web_stuc/end_script.php');?>

</body>

</html>