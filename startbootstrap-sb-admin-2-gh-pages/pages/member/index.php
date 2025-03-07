<?php
require_once('../../../connect.php');


?>

<?php

$sql_script = "SELECT * FROM member ";
$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>
<link rel="stylesheet" href="../../../Bos/plugins/bootstrap-toggle/bootstrap-toggle.min.css">

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



                <h1 class=" text-center ">รายชื่อสมาชิก</h1>
                <a href="member_add.php" class="text-left mb-3 ml-3 btn btn-primary">เพิ่มสมาชิก </a>
                
                
                <table id="myTable" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>select all <input type="checkbox" id="selectAll"></th>
                            <th>ID</th>
                            <th>ชื่อสินค้า</th>
                            <th>นามสกุล</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>ที่อยู่</th>
                            <th>อีเมล</th>
                            <th>เบอร์โทร</th>
                            <th>ระดับการเข้าใช้งาน</th>
                            <th>สถานะบัญชี</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
        require('../connectPDO/connnectpdo.php');
        $isSuperAdmin = $_SESSION['superadmin'] == 1;
        $isAdmin = $_SESSION['admin'] == 1;
        $loggedInUserId = $_SESSION['mmb_id'];
        $hasRecords = false;
        $stmt = $conn->query("SELECT member.*, member_levels.member, member_levels.admin, member_levels.superadmin FROM member LEFT JOIN member_levels ON member.mmb_id = member_levels.mmb_id");
        $stmt->execute();
        $members = $stmt->fetchAll();
        $hasRecords = false;
        foreach ($members as $member) {
    $mmb_id = $member['mmb_id'];
    $mmb_show = $member['mmb_show'];

            $hasRecords = true;
            $canEdit = true;
            $canDelete = true;
            $canSelect = true;
            $canToggle = true;

            if ($isSuperAdmin) {
                if ($member['superadmin'] == 1 && $member['mmb_id'] !== $loggedInUserId) {
                    $canDelete = false;
                    $canEdit = false;
                    $canSelect = false;
                    $canToggle = false;
                } elseif ($member['mmb_id'] === $loggedInUserId) {
                    $canDelete = false;
                    $canEdit = false;
                    $canSelect = false;
                    $canToggle = false;
                }
            } elseif ($isAdmin) {
                if ($member['superadmin'] == 1 || ($member['mmb_id'] === $loggedInUserId) || ($_SESSION['mmb_username'] === $member['mmb_username'])) {
                    $canDelete = false;
                    $canEdit = false;
                    $canSelect = false;
                    $canToggle = false;
                } elseif ($member['admin'] == 1) {
                    $canDelete = false;
                    $canEdit = false;
                    $canSelect = false;
                    $canToggle = false;
                }
            }

            // แสดงปุ่ม "แก้ไข" และ "ลบ" ตามค่า $canEdit และ $canDelete
            ?>
                        <tr>

                            <td> <?php if ($canSelect) : ?>
                                <input type="checkbox" name="delete[]" value="<?php echo $member['mmb_id']; ?>">
                                <?php endif; ?>
                            </td>
                            <td><?php echo $member['mmb_id'] ?></td>
                            <td><?php echo $member['mmb_name'] ?></td>
                            <td><?php echo $member['mmb_surname'] ?></td>
                            <td><?php echo $member['mmb_username'] ?></td>
                            <td class="text-truncate overflow-hidden" style="max-width: 200px;">
                                <?php echo $member['mmb_addr'] ?></td>
                            <td><?php echo $member['mmb_email'] ?></td>
                            <td><?php echo $member['mmb_phone'] ?></td>
                            <td>
                                <?php
    if ($member['superadmin'] == 1) {
        echo 'superadmin';
    } elseif ($member['admin'] == 1) {
        echo 'admin';
    } else {
        echo 'member';
    }
    ?>
                            </td>
                            <td>
                            <?php if ($canToggle) : ?>
                                <input type="checkbox"      
        data-on="เปิดใช้งาน"
        data-off="ปิดใช้งาน"
        data-onstyle="success"
        data-offstyle="danger"
        data-style="ios" class="toggle-switch" data-mmb-id="<?php echo $mmb_id; ?>" <?php echo $mmb_show == 1 ? 'checked' : ''; ?>>
        <?php endif; ?>
</td>

                            <td>
                                <?php if ($canEdit) : ?>
                                <a href="member_edit_admin.php?mmb_id=<?php echo $member['mmb_id'] ?>"
                                    class="btn btn-warning">แก้ไข</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($canDelete) : ?>
                                <a onclick="confirmDelete(<?php echo $member['mmb_id']; ?>, '<?php echo $member['mmb_username']; ?>')"
                                    class="btn btn-danger">ลบ</a>
                                <?php endif; ?>
                            </td>
                        </tr>

                    



                        <?php } ?>
                    </tbody>
                </table>
                <p></p>
                <?php if ($hasRecords) : ?>
    <a onclick="confirmDeleteSelect(<?php echo $member['mmb_id']; ?>)" name="delete_records" class="btn btn-danger">Delete Selected</a>
<?php endif; ?>

<script>
  $(document).ready(function() {
    // Initialize Bootstrap Toggle
    $('.toggle-switch').bootstrapToggle();

    // Handle Toggle Change Event
    $('.toggle-switch').change(function() {
      var mmb_id = $(this).data('mmb-id');
      var mmb_show = $(this).prop('checked') ? 1 : 0;

      // Send AJAX request to update mmb_show value
      $.ajax({
        url: 'update_mmb_show.php',
        method: 'POST',
        data: {mmb_id: mmb_id, mmb_show: mmb_show},
        success: function(response) {
          console.log(response); // Log the response for debugging
        },
        error: function(error) {
          console.error(error); // Log any errors for debugging
        }
      });
    });
  });
</script>


                <script>
                $(document).ready(function() {
                    $('#myTable').DataTable();
                });
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
                    const mmbIds = Array.from(checkboxes).map(checkbox => checkbox.value);

                    fetch('delete_records.php', {
                            method: 'POST',
                            body: JSON.stringify({
                                mmbIds: mmbIds
                            }),
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deletion Successful', 'Items have been deleted successfully', 'success')
                                    .then(() => {
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
    function confirmDelete(mmb_id, mmb_username) {
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล',
            text: `คุณต้องการลบข้อมูล "${mmb_username}" ใช่หรือไม่?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // ถ้าผู้ใช้กดยืนยันการลบ
                fetch(`member_delete.php?mmb_id=${mmb_id}`)
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
    
    

    <?php include('../../web_stuc/end_script.php');?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
 
<script src="../../../Bos/plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</body>

</html>