
<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php');?>

<body id="page-top">
    



<?php
require_once('../../../connect/connect.php');


// Check if the user is logged in
if (!isset($_SESSION['mmb_id'])) {
    header('Location: login.php');
    exit;
}

// Get the user's status from the session
$userStatus = $_SESSION['status'];

// Check if the member ID is provided in the query string
if (isset($_GET['mmb_id'])) {
    $mmb_id = $_GET['mmb_id'];

    // Search for member data in the database
    $sql = "SELECT * FROM member WHERE mmb_id = '$mmb_id'";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];

        // Check the access control conditions
        if ($userStatus == 'superadmin') {
            // Superadmin can edit admin and member but not other superadmins
            if ($status == 'superadmin') {
                echo "Superadmins cannot be edited.";
                exit;
            }
        } elseif ($userStatus == 'admin') {
            // Admin can only edit members, not superadmins or other admins
            if ($status == 'superadmin' || $status == 'admin') {
                echo "You do not have permission to edit this user.";
                exit;
            }
        }

        // Proceed with editing the user
        $mmb_name = $row['mmb_name'];
        $mmb_surname = $row['mmb_surname'];
        $mmb_username = $row['mmb_username'];
        $mmb_addr = $row['mmb_addr'];
        $mmb_phone = $row['mmb_phone'];
        $mmb_email = $row['mmb_email'];
        $mmb_show = $row['mmb_show'];
        $status = $row['status'];
    } else {
        // If the member to edit is not found in the database
        echo "ไม่พบข้อมูลสมาชิกที่ต้องการแก้ไข";
        exit;
    }
} else {
    // If the member ID is not provided in the query string
    echo "ไม่ระบุรหัสสมาชิกที่ต้องการแก้ไข";
    exit;
}

// Handle the editing form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check the access control conditions for form submission
    if ($userStatus == 'superadmin') {
        // Superadmin can edit admin and member but not other superadmins
        if ($status == 'superadmin') {
            echo "Superadmins cannot be edited.";
            exit;
        }
    } elseif ($userStatus == 'admin') {
        // Admin can only edit members, not superadmins or other admins
        if ($status == 'superadmin' || $status == 'admin') {
            echo "You do not have permission to edit this user.";
            exit;
        }
    }

    // Handle the form data and update the user's information in the database
    $new_mmb_name = $_POST["mmb_name"];
    $new_mmb_surname = $_POST["mmb_surname"];
    $new_mmb_username = $_POST["mmb_username"];
    $new_mmb_addr = $_POST["mmb_addr"];
    $new_mmb_phone = $_POST["mmb_phone"];
    $new_mmb_email = $_POST["mmb_email"];
    $new_mmb_show = $_POST["mmb_show"];
    $new_status = $_POST["status"];

    // Update the data in the database
    $update_sql = "UPDATE member SET mmb_name = '$new_mmb_name', mmb_surname = '$new_mmb_surname', mmb_username = '$new_mmb_username', mmb_addr = '$new_mmb_addr', mmb_phone = '$new_mmb_phone',status = '$new_status', mmb_email = '$new_mmb_email', mmb_show = '$new_mmb_show' WHERE mmb_id = '$mmb_id'";
    
    if ($proj_connect->query($update_sql) === TRUE) {
        $edit_success = true;
    } else {
        echo "ข้อผิดพลาดในการแก้ไขข้อมูล: " . $proj_connect->error;
    }
}
?>


</body>

</html>


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
        <h2>แก้ไขข้อมูลสมาชิก</h2>
        <form action="" method="post"  enctype="multipart/form-data" onSubmit="return chkdata(this);">
            <div class="mb-3">
                <label for="mmb_name" class="form-label">ชื่อ:</label>
                <input type="text" name="mmb_name" id="mmb_name" class="form-control"
                    value="<?php echo $mmb_name; ?>">
            </div>
            <div class="mb-3">
                <label for="mmb_surname" class="form-label">นามสกุล:</label>
                <input type="text" name="mmb_surname" id="mmb_surname" class="form-control"
                    value="<?php echo $mmb_surname; ?>">
            </div>
            <div class="mb-3">
                <label for="mmb_username" class="form-label">Username:</label>
                <input type="text" name="mmb_username" id="mmb_username" class="form-control"
                    value="<?php echo $mmb_username; ?>">
            </div>
           
            <div class="mb-3">
                <label for="mmb_addr" class="form-label">ที่อยู่:</label>
                <textarea name="mmb_addr" id="mmb_addr" rows="4" class="form-control"
                    ><?php echo $mmb_addr; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="mmb_phone" class="form-label">เบอร์โทร:</label>
                <input type="tel" name="mmb_phone" id="mmb_phone" class="form-control"
                    value="<?php echo $mmb_phone; ?>">
            </div>
            <div class="mb-3">
                <label for="mmb_email" class="form-label">e-mail:</label>
                <input type="email" name="mmb_email" id="mmb_email" class="form-control"
                    value="<?php echo $mmb_email; ?>">
            </div>
    
           
        
            <div class="mb-3">
    <label for="status" class="form-label">ให้สิทธิ์ผู้ดูแลระบบ:</label>
    <select id="status" name="status" class="form-control">
        <option value="" selected>..ให้สิทธิ์ผู้ดูแลระบบ..</option>
        <?php
        if (isset($_SESSION['status']) && $_SESSION['status'] === 'superadmin') {
            // หากผู้ใช้เป็น superadmin
        
            echo '<option value="superadmin" >superadmin</option>';
        }
        ?>
        <option value="" <?php if ($status == '') echo "selected"; ?>>member</option>
        <option value="admin" <?php if ($status == 'admin') echo "selected"; ?>>admin</option>
    </select>
</div>

            <div class="mb-3">
                <label for="mmb_show" class="form-label">ปิดใช้งานบัญชีชั่วคราว:</label>
                <select id="mmb_show" name="mmb_show" class="form-control">
                <option value="" selected>..กรุณาเลือก..</option>
                    <option value="1" <?php if ($mmb_show == 1) echo "selected"; ?>>เผยแพร่</option>
                    <option value="0" <?php if ($mmb_show == 0) echo "selected"; ?>>ปิดใช้งานชั่วคราว</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="submit" name="submit" value="บันทึกการแก้ไข" class="btn btn-primary">
                <a href="../member/" class="btn btn-secondary">cancel</a>
            </div>
        </form>
    </div>
    <?php if (isset($edit_fail) && $edit_fail) : ?>
        <script>
        Swal.fire({
            icon: "error",
            title: "ขออภัย!",
            text: "คุณไม่มีสิทธิ์เปลี่ยนระดับเป็นแอดมิน",
            showConfirmButton: true // เปลี่ยนเป็น true เพื่อให้มีปุ่ม OK
        });
    </script>
    <?php endif; ?>
    <?php if (isset($edit_success) && $edit_success) : ?>
        <script>
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "สำเร็จ!",
                    text: "แก้ไขข้อมูลผู้ใช้เรียบร้อย",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "../member/"; // นำแอดมินไปยังหน้า product_show.php
                });
            </script>
 
    <?php endif; ?>




    <script>
function chkdata(form) {
    var errorMessage = "โปรดระบุ";
    showError = 0;

    // Check if the name field is empty
    if (form.mmb_name.value === "") {
        errorMessage += " ชื่อ";
        showError = 1;
    }

    // Check if the surname field is empty
    if (form.mmb_surname.value === "") {
        errorMessage += " นามสกุล";
        showError = 1;
    }

    // Check if the username contains only letters and numbers
    if (!/^[a-zA-Z0-9_]+$/.test(form.mmb_username.value)) {
        errorMessage += " ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น";
        showError = 1;
    }

    // Check if the address field is empty
    if (form.mmb_addr.value === "") {
        errorMessage += " ที่อยู่";
        showError = 1;
    }
    if (form.mmb_phone.value === "") {
        errorMessage += " เบอร์โทรศัพท์";
        showError = 1;
    }

    // Check if the phone field consists of exactly 9 digits
    if (form.mmb_phone.value && !/^\d{9,}$/.test(form.mmb_phone.value)) {
    errorMessage = " เบอร์โทรศัพท์ไม่ถูกต้อง";
    showError = 1;
}
    // Check if the email field is empty
    if (form.mmb_email.value === "") {
        errorMessage += " อีเมล ";
        showError = 1;
    }

    // Check if the show field is empty
    if (form.mmb_show.value === "") {
        errorMessage += " การแสดงบัญชี";
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
 
  









    <?php include('../../web_stuc/end_script.php');?>
</body>

</html>