<?php
// เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
require_once('../../../connect.php');

// ตรวจสอบว่าผู้ใช้มีค่า session admin ไม่เท่ากับหนึ่ง

$uploadFolderURL = '../uploads/'; // ปรับเส้นทางนี้ตามโครงสร้างโฟลเดอร์ของคุณ

?>

<?php
// เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT prd.*, pty.* FROM product prd left join product_type pty on prd.pty_id=pty.pty_id";
$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result = mysqli_num_rows($result);
?>

<?php

$sql_script = "SELECT prd.*, pty.* FROM product prd LEFT JOIN product_type pty ON prd.pty_id = pty.pty_id WHERE prd.prd_show = 1";
$result1 = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result1 = mysqli_num_rows($result1);

?>
<?php

$sql_script = "SELECT prd.*, pty.* FROM product prd LEFT JOIN product_type pty ON prd.pty_id = pty.pty_id WHERE prd.prd_show = 0";
$result2 = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result2 = mysqli_num_rows($result2);

?>
<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php'); ?>
<link rel="stylesheet" href="../../../Bos/plugins/bootstrap-toggle/bootstrap-toggle.min.css">

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('../../web_stuc/side_bar.php'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('../../web_stuc/top_bar.php'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <h1 class=" text-center ">หน้าจัดการสินค้า</h1>
                <a href="product_add_copy.php" class="text-left mb-3 ml-3 btn btn-primary">เพิ่มสินค้า </a>
                <div class="card shadow-lg">
                    <div class="card-body">
                        <table id="myTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>select all <input type="checkbox" id="selectAll"></th>
                                    <th>ID</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>รายละเอียด</th>
                                    <th>รูป</th>
                                    <th>ราคา</th>
                                    <th>ประเภทสินค้า</th>
                                    <th>แสดงสินค้า</th>
                                    <th>สินค้าแนะนำ</th>
                                    <th>แก้ไข</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require('../connectPDO/connnectpdo.php');
                                $stmt = $conn->query("SELECT p.*, pt.pty_name 
                        FROM product p
                        INNER JOIN product_type pt ON p.pty_id = pt.pty_id");
                                $stmt->execute();
                                $products = $stmt->fetchAll();

                                $hasRecords = false;
                                foreach ($products as $product) {
                                    $prd_id = $product['prd_id'];
                                    $prd_show = $product['prd_show'];
                                    $prd_reccom = $product['prd_reccom'];
                                    $hasRecords = true;
                                ?>
                                    <tr>
                                        <td><input type="checkbox" name="delete[]" value="<?php echo $product['prd_id']; ?>"></td>
                                        <td><?php echo $product['prd_id'] ?></td>
                                        <td><?php echo $product['prd_name'] ?></td>
                                        <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $product['prd_desc'] ?></td>
                                        <td><img src="<?php echo $product['prd_img'] ?>" alt="" style="max-width: 100px; max-height: 100px;"></td>
                                        <td><?php echo $product['prd_price'] ?></td>
                                        <td><?php echo $product['pty_name'] ?></td>
                                        <td>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck<?php echo $prd_id; ?>" data-prd-id="<?php echo $prd_id; ?>" <?php echo $prd_show == 1 ? 'checked' : ''; ?>>
                                            
                                            </div>

                                        </td>
                                    <td>
                                    <input type="checkbox" data-on="แสดง" data-off="ซ่อน" data-onstyle="success" data-offstyle="danger" data-style="ios" class="toggle-switch-reccom" data-prd-id="<?php echo $prd_id; ?>" <?php echo $prd_reccom == 1 ? 'checked' : ''; ?>>
                                
                                </td>
                                        <td><a href="product_edit.php?prd_id=<?php echo $product['prd_id'] ?>" class="btn btn-warning">แก้ไข</a></td>
                                        <td><a onclick="confirmDelete(<?php echo $product['prd_id']; ?>, '<?php echo $product['prd_name']; ?>')" class="btn btn-danger">ลบ</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($hasRecords) : ?>
                    <a onclick="confirmDeleteSelect(<?php echo $product['prd_id']; ?>)" name="delete_records" class="btn btn-danger">Delete Selected</a>
                <?php endif; ?>
                <script>
                    $(document).on('change', '.form-check-input', function() {
        var prd_id = $(this).data('prd-id');
        var prd_show = $(this).prop('checked') ? 1 : 0;

        // Send AJAX request to update prd_show value
        $.ajax({
            url: 'update_prd_show.php',
            method: 'POST',
            data: {
                prd_id: prd_id,
                prd_show: prd_show
            },
            success: function(response) {
                console.log(response); // Log the response for debugging
            },
            error: function(error) {
                console.error(error); // Log any errors for debugging
            }
        });
    });

                </script>


 

                <script>
                    $(document).ready(function() {
                        // Initialize Bootstrap Toggle
                        $('.toggle-switch-reccom').bootstrapToggle();

                        // Handle Toggle Change Event
                        $('.toggle-switch-reccom').change(function() {
                            var prd_id = $(this).data('prd-id');
                            var prd_reccom = $(this).prop('checked') ? 1 : 0;

                            // Send AJAX request to update prd_show value
                            $.ajax({
                                url: 'update_prd_reccom.php',
                                method: 'POST',
                                data: {
                                    prd_id: prd_id,
                                    prd_reccom: prd_reccom
                                },
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



                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
                </script>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('../../web_stuc/footer.php'); ?>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        function confirmDelete(prd_id, prd_name) {
            Swal.fire({
                title: 'ยืนยันการลบข้อมูล',
                text: `คุณต้องการลบข้อมูล "${prd_name}" ใช่หรือไม่?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ถ้าผู้ใช้กดยืนยันการลบ
                    fetch(`product_delete.php?prd_id=${prd_id}`)
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
            const prdIds = Array.from(checkboxes).map(checkbox => checkbox.value);

            fetch('delete_records.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        prdIds: prdIds
                    }),
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
        $(document).on('change', '.toggle-mmb-show', function() {
            let id = $(this).data('id');
            let isChecked = $(this).prop('checked');
            updateMmbShow(id, isChecked);
        });

        function updateMmbShow(id, isChecked) {
            $.ajax({

                type: "PUT",
                url: "update_prd_show.php",
                data: JSON.stringify({
                    id: id,
                    prd_show: isChecked ? 1 : 0
                }),
                contentType: "application/json; charset=utf-8",

                success: function(response) {
                    // อัปเดตสำเร็จ
                    toastr.success('อัพเดทข้อมูลเสร็จเรียบร้อย');
                },
                error: function() {
                    // อัปเดตไม่สำเร็จ
                    toastr.error('เกิดข้อผิดพลาดในการอัปเดท');
                }
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
    <?php include('../../web_stuc/end_script.php'); ?>
    <script src="../../../Bos/plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>


</body>

</html>