<?php
require_once('../../../connect/connect.php');

// Check if the product type ID is provided in the URL
if (isset($_GET['pty_id'])) {
    $pty_id = $_GET['pty_id'];

    // Fetch product type data based on the provided product type ID
    $sql_script = "SELECT * FROM product_type WHERE pty_id = $pty_id";
    $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_error($proj_connect));
    $row_result = mysqli_fetch_assoc($result);
} else {
    // Handle the case where pty_id is not provided in the URL
    echo "Product Type ID not provided.";
    exit;
}

// Check if the form is submitted for updating the product type information
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $new_pty_name = $_POST['pty_name'];
    $new_pty_desc = $_POST['pty_desc'];
    $new_pty_show = $_POST['pty_show'];

    // Check if the new pty_name already exists, excluding the current product type
    $check_sql = "SELECT pty_id FROM product_type WHERE pty_name = '$new_pty_name' AND pty_id != $pty_id";
    $check_result = mysqli_query($proj_connect, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // If pty_name already exists (excluding the current product type), handle the error (you can redirect or display an error message)
        $already_name = true;
    } else {
        // Update the product type's information in the database
        $update_sql = "UPDATE product_type SET pty_name = '$new_pty_name', pty_desc = '$new_pty_desc', pty_show = '$new_pty_show' WHERE pty_id = $pty_id";

        if (mysqli_query($proj_connect, $update_sql)) {
            $registration_success = true;
        } else {
            echo "Error updating product type information: " . mysqli_error($proj_connect);
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
                    
                },
               pty_desc: {
                    required: true,
                   
                }
               
                
            },
            messages: {
           
                pty_name: {
                    required: 'โปรดกรอกข้อมูล ชื่อผู้ใช้',
                 
                },
                pty_desc: {
                    required: 'โปรดกรอกรหัสผ่าน',
                
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

        // เพิ่มกฎสำหรับตรวจสอบรหัสผ่านที่แข็งแกร่ง
        $.validator.addMethod('strongPassword', function (value, element) {
            return this.optional(element) ||
                value.length >= 6 &&
                /\d/.test(value) &&
                /[a-z]/i.test(value);
        }, 'รหัสผ่านควรมีอย่างน้อย 6 ตัว, ประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก');

        // เพิ่มกฎสำหรับตรวจสอบชื่อผู้ใช้ที่ประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น
        $.validator.addMethod('alphanumeric', function (value, element) {
    return this.optional(element) || /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]+$/.test(value);
}, 'ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลข');
    });
</script>
<script>
$(document).ready(function() {
    var pty_id = <?php echo json_encode($pty_id); ?>; // รับค่า ID ของประเภทผลิตภัณฑ์จาก PHP

    // ส่งคำขอ AJAX เพื่อตรวจสอบจำนวนสินค้าในประเภทนี้
    $.ajax({
        url: 'check-product-in-type.php', // แทนที่ด้วย URL ของไฟล์ PHP ที่ทำการตรวจสอบ
        type: 'POST',
        data: {pty_id: pty_id},
        success: function(response) {
            if(response > 0) {
                // หากมีสินค้าในประเภทนี้ ทำให้ฟิลด์เป็นสีเทา
                $('#pty_name').prop('readonly', true).css('background-color', '#e9ecef');
            }
        }
    });
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
        <h1>Edit Product Type Information</h1>
        <form id="yourFormId" method="POST" >
            <div class="mb-3">
                <label for="pty_name" class="form-label">ชื่อประเภทผลิตภัณฑ์:</label>
                <input type="text" class="form-control" name="pty_name"  id="pty_name"  value="<?php echo $row_result['pty_name']; ?>" >
            </div>

            <div class="mb-3">
                <label for="pty_desc" class="form-label">รายละเอียด:</label>
                <input type="text" class="form-control" name="pty_desc"  id="pty_desc" value="<?php echo $row_result['pty_desc']; ?>">
            </div>

            <div class="mb-3">
                <label for="pty_show" class="form-label">แสดงผล:</label>
                <select class="form-select" name="pty_show">
                    <option value="0" <?php if ($row_result['pty_show'] == 0) echo "selected"; ?>>ไม่แสดง</option>
                    <option value="1" <?php if ($row_result['pty_show'] == 1) echo "selected"; ?>>แสดง</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">บันทึก</button>
            <a href="../product_type/" class="btn btn-secondary" role="button">Cancel</a>
        </form>
    </div>
<?php if (isset($registration_success) && $registration_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สำเร็จ!!',
                text: 'แก้ไขข้อมูลเรียบร้อย',
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
    <!-- Bootstrap core JavaScript-->
    <?php include('../../web_stuc/end_script.php');?>



</body>

</html>