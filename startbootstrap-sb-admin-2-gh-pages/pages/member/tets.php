<?php
require_once('../../../connect/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $mmb_name = $_POST['mmb_name'];
    $mmb_surname = $_POST['mmb_surname'];
    $mmb_username = $_POST['mmb_username'];
    $mmb_pwd = $_POST['mmb_pwd'];
    $mmb_confirm_pwd = $_POST['mmb_confirm_pwd'];
    $mmb_addr = $_POST['mmb_addr'];
    $mmb_phone = $_POST['mmb_phone'];
    $member = $_POST['member'];

    // Check if the username already exists
    $check_username_sql = "SELECT * FROM member WHERE mmb_username = '$mmb_username'";
    $result = mysqli_query($proj_connect, $check_username_sql);
    if (mysqli_num_rows($result) > 0) {
        // Username already exists, show an error message
        echo "<script type='text/javascript'>";
        echo "alert('ชื่อผู้ใช้นีมีอยู่ในระบบแล้ว');";
        echo "window.location = 'member_add.php'; ";
        echo "</script>";
        exit();
    } else {
        if (!preg_match("/^[a-zA-Z0-9_]*$/", $mmb_username)) {
            // ไม่ถูกต้องเนื่องจากมีอักขระที่ไม่ใช่อักษรอังกฤษ
            echo "<script type='text/javascript'>";
            echo "alert('ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น');";
            echo "window.location = 'member_add.php'; ";
            echo "</script>";
            exit();
        }

        //เพิ่มเงื่อนไขตรวจสอบรหัสผ่านที่มีความปลอดภัยมากขึ้น
        if(strlen($mmb_pwd) < 6 || !preg_match("#[0-9]+#", $mmb_pwd) || !preg_match("#[a-z]+#",$mmb_pwd) || !preg_match("#[A-Z]+#", $mmb_pwd)) {
            echo "<script type='text/javascript'>";
            echo "alert('รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษรและประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่และตัวอักษรตัวเล็ก');";
            echo "window.location = 'member_add.php'; ";
            echo "</script>";
            exit();
        }

        //ตรวจสอบความถูกต้องของรหัสผ่าน
        if($mmb_pwd !=  $mmb_confirm_pwd){
            echo "<script type='text/javascript'>";
            echo "alert('รหัสผ่านไม่ตรงกัน');";
            echo "window.location = 'member_add.php'; ";
            echo "</script>";
            exit();
        }

        // Hash the password before storing it in the database
        $password_hash = password_hash($mmb_pwd, PASSWORD_DEFAULT);

        // Insert the new member data into the database with the hashed password
        $insert_sql = "INSERT INTO member (mmb_name, mmb_surname, mmb_username, mmb_pwd, mmb_addr, mmb_phone, member) VALUES ('$mmb_name', '$mmb_surname', '$mmb_username', '$password_hash', '$mmb_addr', '$mmb_phone', '$member')";

        if (mysqli_query($proj_connect, $insert_sql)) {
            // Registration successful
            $registration_success = true;
        } else {
            echo "Error adding member: " . mysqli_error($proj_connect);
        }
    }
}
?>




    <script type="text/javascript">
        function chkdata(boarddata) {
            txtError = "กรุณากรอก";
            showError = 0;

            if (boarddata.mmb_name.value == "") {
                showError = 1;
                txtError = txtError + " ชื่อ";
            }

            if (boarddata.mmb_surname.value == "") {
                showError = 1;
                txtError = txtError + " นามสกุล";
            }
            if (boarddata.mmb_username.value == "") {
                showError = 1;
                txtError = txtError + " ชื่อผู้ใช้";
            }
            if (boarddata.mmb_pwd.value == "") {
                showError = 1;
                txtError = txtError + " รหัสผ่าน";
            }

            if (boarddata.mmb_addr.value == "") {
                showError = 1;
                txtError = txtError + " ที่อยู่";
            }
            if (boarddata.mmb_phone.value == "") {
                showError = 1;
                txtError = txtError + " เบอร์โทร";
            }


            if (boarddata.mmb_phone.value !== "") {
                // เพิ่มการตรวจสอบรูปแบบของหมายเลขโทรศัพท์ (phone number) เฉพาะเมื่อไม่ใช่ค่าว่าง
                var phoneNumber = boarddata.mmb_phone.value;
                var phonePattern = /^\d{9,}$/; // เรียกใช้รูปแบบที่คุณต้องการ (ในตัวอย่างนี้ 10 ตัวเลข)

                if (!phonePattern.test(phoneNumber)) {
                    showError = 1;
                    txtError = " เบอร์โทรศัพท์ไม่ถูกต้อง";
                    alert(txtError); // แสดงข้อความการแจ้งเตือน
                    return false;
                }
            }

            if (showError == 1) {
                alert(txtError);
                return false;
            }

            return true; // อนุญาตให้ฟอร์มส่งข้อมูลเมื่อข้อมูลถูกต้อง
        }
    </script>


    <div class="d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="card border-0 shadow">
                        <!-- action ด้วยค่าว่าง "" คือการส่ง Form นี้เข้าสู่หน้าปัจจุบัน -->
                        <!-- method POST คือการส่ง Form ให้อยู่ในรูปของ POST เพื่อส่งข้อมูล Form ในพื้นหลังการทำงาน -->
                        <form action="" method="POST" onSubmit="return(chkdata(this));">
                            <h4 class="card-header text-center">สมัครสมาชิก</h4>
                            <div class="card-body px-4">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="mmb_name" class="col-form-label">Name:</label>
                                        <input type="text" class="form-control" id="mmb_name" name="mmb_name" placeholder="firstname">
                                    </div>
                                    <div class="col-12">
                                        <label for="mmb_surname" class="col-form-label">lastname:</label>
                                        <input type="text" class="form-control" id="mmb_surname" name="mmb_surname" placeholder="lastname"> </ร>
                                    </div>
                                    <div class="col-12">
                                        <label for="mmb_username" class="col-form-label">username:</label>
                                        <input type="text" class="form-control" id="mmb_username" name="mmb_username" placeholder="username">

                                    </div>
                                    <div class="col-12">
                                        <label for="mmb_pwd">Password <br>

                                        </label>
                                        <input type="password" id="mmb_pwd" class="form-control" name="mmb_pwd" placeholder="password">
                                    </div>
                                    <div class="col-12">
                                        <label for=" mmb_confirm_pwd">Confirm Password <br>

                                        </label>
                                        <input type="password" id="mmb_confirm_pwd" class="form-control" name="mmb_confirm_pwd" placeholder="Confirm Password">
                                    </div>
                                    <div class="col-12">

                                        <select class="form-control" id="member" name="member" required hidden>
                                            <option value="1" selected>Member</option>
                                        </select>
                                    </div>


                                    <div class="col-12">
                                        <label for="mmb_addr">address<br>

                                        </label>
                                        <textarea id="mmb_addr" class="form-control" name="mmb_addr"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label for="mmb_addr">phone<br>

                                        </label>
                                        <input type="tel" id="mmb_phone" class="form-control" name="mmb_phone" placeholder="089xxxxxxx">
                                    </div>




                                    <div class="col-12 text-center py-3">
                                        <input type="submit" name="button" id="button" class="btn btn-outline-primary d-grid mx-auto w-100" value="สมัครสมาชิก">
                                        <a href="index.php">กลับหน้าหลัก</a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($registration_success) && $registration_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สมัครสมาชิกสำเร็จ',
                text: 'คุณสามารถเข้าสู่ระบบได้เดี่ยวนี้',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'index.php';
            });
        </script>
    <?php endif; ?>