<?php
require_once('../../../connect/connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $pty_name = $_POST['pty_name'];
    $pty_desc = $_POST['pty_desc'];
    $pty_show = $_POST['pty_show'];

    // Check if pty_name already exists
    $check_sql = "SELECT pty_name FROM product_type WHERE pty_name = '$pty_name'";
    $check_result = mysqli_query($proj_connect, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // If pty_name already exists, handle the error (you can redirect or display an error message)
        $already_name = true;
    } else {
        // Insert the new product type data into the database
        $insert_sql = "INSERT INTO product_type (pty_name, pty_desc, pty_show) VALUES ('$pty_name', '$pty_desc', '$pty_show')";

        if (mysqli_query($proj_connect, $insert_sql)) {
            $registration_success = true;

            // You can redirect to another page or take appropriate action here.
        } else {
            echo "Error adding product type: " . mysqli_error($proj_connect);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">
<script>
    $(document).ready(function () {
        $("#yourFormId").validate({
            rules: {
                pty_name: {
                    required: true,
                    remote: {
                        url: "check-product-type.php",
                        type: "post",
                        data: {
                            pty_name: function () {
                                return $("#pty_name").val();
                            }
                        }
                    }
                },
                pty_desc: {
                    required: true
                },
                pty_show: {
                    required: true
                }
            },
            messages: {
                pty_name: {
                    required: 'โปรดกรอกข้อมูล ชื่อประเภท',
                    remote: 'ชื่อประเภทนี้มีในระบบแล้ว'
                },
                pty_desc: {
                    required: 'โปรดกรอกข้อมูล รายละเอียด'
                },
                pty_show: {
                    required: 'กรุณาเลือกแสดงประเภทสินค้า'
                }
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            errorPlacement: function (error, element) {
                if (element.hasClass('select2')) {
                    error.insertAfter(element.next('span'));
                } else {
                    error.insertAfter(element);
                }
            }
        });

      
       
    return 
    });
</script>
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
                <div class="container">
        <h1 class="mt-4">Add Product Type</h1>
        <form action="" method="POST" id="yourFormId">
            <div class="mb-3">
                <label for="pty_name" class="form-label">Product Type Name:</label>
                <input type="text" id="pty_name" name="pty_name" class="form-control">
            </div>
            <div class="mb-3">
                <label for="pty_desc" class="form-label">Description:</label>
                <textarea id="pty_desc" name="pty_desc" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="pty_show" class="form-label">แสดงผล:</label>
                <select id="pty_show" name="pty_show" class="form-select">
                    <option value="">..กรุณาเลือก..</option>
                    <option value="0">ไม่แสดง</option>
                    <option value="1">แสดง</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="../product_type/" class="btn btn-secondary">cancel</a>
        </form>
    </div>

    <?php if (isset($registration_success) && $registration_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!!',
                text: 'เพิ่มข้อมูลเรียบร้อย',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '../product_type/';
            });
        </script>
    <?php endif; ?>
    <?php if (isset($already_name) && $already_name) : ?>
        <script>
        Swal.fire({
            icon: "error",
            title: "ขออภัย!",
            text:"ชื่อประเภทสินค้านี้มีในระบบแล้ว",
            showConfirmButton: true // เปลี่ยนเป็น true เพื่อให้มีปุ่ม OK
        });
    </script>
    <?php endif; ?>


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
                window.location.href = `product_type_delete.php?pty_id=${pty_id}`;
            }
        });
    }
    </script>

<script>
function chkdata(form) {
    var errorMessage = "โปรดระบุ";
    showError = 0;

    // Check if the name field is empty
    if (form.pty_name.value === "") {
        errorMessage += " ชื่อ";
        showError = 1;
    }

    // Check if the surname field is empty
    if (form.pty_desc.value === "") {
        errorMessage += " รายละเอียด";
        showError = 1;
    }
    if (form.pty_show.value === "") {
        errorMessage += " แสดงประเภทสินค้า";
        showError = 1;
    }
   

    // Display a single alert message with all the empty fields and validation errors

    if (showError == 1) {
            alert(errorMessage);
            return false;
        }

    return true;
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
