<!DOCTYPE html>
<html lang="en">

<?php include('mainweb_page/head.php'); ?>



<body>



















    <script>
        function validateForm() {
            // ดึงค่าที่ผู้ใช้กรอกมาจากฟอร์ม
            var email = document.getElementById('mmb_email').value;
            var phone = document.getElementById('mmb_phone').value;

            // ตรวจสอบรูปแบบ email โดยใช้ Regular Expression
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').innerText = 'กรุณากรอก Email ให้ถูกต้อง';
                return false;
            } else {
                document.getElementById('emailError').innerText = '';
            }

            // ตรวจสอบรูปแบบเบอร์โทรศัพท์
            var phoneRegex = /^[0-9]+$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById('phoneError').innerText = 'กรุณากรอกเบอร์โทรศัพท์ที่ถูกต้อง';
                return false;
            } else {
                document.getElementById('phoneError').innerText = '';
            }

            // ถ้าผ่านการตรวจสอบทั้งหมด
            return true;
        }
    </script>
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
            } else if (!/^[a-zA-Z0-9_]+$/.test(boarddata.mmb_username.value)) {
                showError = 1;
                txtError = " ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น";
            }

            if (boarddata.mmb_pwd.value == "") {
                showError = 1;
                txtError = txtError + " รหัสผ่าน";
            } else {
                var password = boarddata.mmb_pwd.value;
                if (password.length < 6 || !/[0-9]/.test(password) || !/[a-z]/.test(password) || !/[A-Z]/.test(password)) {
                    showError = 1;
                    txtError = " รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษรภาษาอังกฤษและประกอบไปด้วยตัวเลข,ตัวอักษรตัวใหญ่และตัวเล็ก";
                }
            }

            if (boarddata.mmb_addr.value == "") {
                showError = 1;
                txtError = txtError + " ที่อยู่";
            }

            if (boarddata.mmb_email.value == "") {
                showError = 1;
                txtError = txtError + " อีเมล";
            }
            if (boarddata.mmb_phone.value == "") {
                showError = 1;
                txtError = txtError + " เบอร์โทร";
            }

            if (boarddata.mmb_phone.value !== "") {
                var phoneNumber = boarddata.mmb_phone.value;
                var phonePattern = /^\d{9,}$/;

                if (!phonePattern.test(phoneNumber)) {
                    showError = 1;
                    txtError = " เบอร์โทรศัพท์ไม่ถูกต้อง";
                }
            }

            if (boarddata.mmb_pwd.value !== boarddata.mmb_confirm_pwd.value) {
                showError = 1;
                txtError = "รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน";
            }

            if (showError == 1) {
                alert(txtError);
                return false;
            }

            return true;
        }
    </script>
    <!-- jQuery -->


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
$(document).ready(function() {
    // Define custom validation methods
    $.validator.addMethod('strongPassword', function(value, element) {
        return this.optional(element) ||
               value.length >= 6 &&
               /\d/.test(value) &&
               /[a-z]/i.test(value);
    }, 'รหัสผ่านควรมีอย่างน้อย 6 ตัว, ประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก');
    
    $.validator.addMethod('alphanumeric', function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    }, 'ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น');

    // Initialize form validation
    $("#yourFormId").validate({
        // Your validation rules
        rules: {
                    mmb_name: {
                        required: true,
                    },
                    mmb_surname: {
                        required: true,
                    },
                    mmb_addr: {
                        required: true,
                    },
                    mmb_email: {
                        required: true,
                        email: true
                    },
                    mmb_phone: {
                        required: true,
                       
                      
                    },
                    mmb_username: {
                        required: true,
                        alphanumeric: true,
                        remote: {
                            url: "check-username.php", // เปลี่ยนเป็น URL ของเซิร์ฟเวอร์ของคุณ
                            type: "post",
                            data: {
                                mmb_username: function() {
                                    return $("#mmb_username").val();
                                }
                            }
                        }
                    },
                    mmb_pwd: {
                        required: true,
                        minlength: 6,
                        strongPassword: true
                    },
                    mmb_confirm_pwd: {
                        required: true,
                        equalTo: "#mmb_pwd"
                    }

                },
                messages: {
                    mmb_name: 'โปรดกรอกข้อมูล ชื่อ',
                    mmb_surname: 'โปรดกรอกข้อมูล นามสกุล',
                    mmb_email: {
                        required: 'โปรดกรอกข้อมูล Email',
                        email: 'โปรดกรอก Email ให้ถูกต้อง'
                    },
                    mmb_addr: {
                        required: 'โปรดกรอกข้อมูล ที่อยู่',

                    },
                    mmb_phone: {
                        required: 'โปรดกรอกข้อมูล เบอร์โทรศัพท์',
                    
                    },
                    mmb_username: {
                        required: 'โปรดกรอกข้อมูล ชื่อผู้ใช้',
                        alphanumeric: 'ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น',
                        remote: 'ชื่อผู้ใช้ถูกใช้ไปแล้ว'
                    },
                    mmb_pwd: {
                        required: 'โปรดกรอกรหัสผ่าน',
                        minlength: 'รหัสผ่านควรมีอย่างน้อย 6 ตัว',
                        strongPassword: 'รหัสผ่านควรประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก'
                    },
                    mmb_confirm_pwd: {
                        required: 'โปรดกรอกยืนยันรหัสผ่าน',
                        equalTo: 'รหัสผ่านไม่ตรงกัน'
                    }
                },
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2')) {
                error.insertAfter(element.next('span'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            // If form is valid, submit it via fetch
            const formData = new FormData(form);
            
            fetch('php-line-login-main/register.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Registration successful.',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'index.php'; // Redirect or other actions
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.errorMessage,
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                });
            });
        }
    });
});
</script>



    <div class="d-flex align-items-center min-vh-100">
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <div class="card border-0 shadow">
                        <!-- action ด้วยค่าว่าง "" คือการส่ง Form นี้เข้าสู่หน้าปัจจุบัน -->
                        <!-- method POST คือการส่ง Form ให้อยู่ในรูปของ POST เพื่อส่งข้อมูล Form ในพื้นหลังการทำงาน -->
                        <form id="yourFormId" action="" method="POST">
                       
                            <h4 class="card-header text-center">
                            <a href="index.php" class="d-block"><img src="assets/img/logo.png" alt="Login Logo"></a>      
                            สมัครสมาชิก</h4>
                            <div class="card-body px-4">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label for="mmb_name" class="col-form-label">ชื่อจริง:</label>
                                        <input type="text" class="form-control" id="mmb_name" name="mmb_name" placeholder="กรุณากรอกชื่อจริง">
                                    </div>
                                    <div class="col-12">
                                        <label for="mmb_surname" class="col-form-label">นามสกุล:</label>
                                        <input type="text" class="form-control" id="mmb_surname" name="mmb_surname" placeholder="กรุณากรอกนามสกุล"> </ร>
                                    </div>
                                    <div class="col-12">

                                        <label for="mmb_username" class="col-form-label">ชื่อผู้ใช้:</label>
                                        <p class="text-danger">*ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น*</p>
                                        <input type="text" class="form-control" id="mmb_username" name="mmb_username" placeholder="กรุณากรอกชื่อผู้ใช้">

                                    </div>
                                    <div class="col-12">
                                        <label for="mmb_pwd">รหัสผ่าน:<br>
                                            <p class="text-danger">*รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษรอังกฤษและประกอบไปด้วยตัวเลข,ตัวอักษรตัวใหญ่และตัวเล็ก*</p>

                                        </label>
                                        <input type="password" id="mmb_pwd" class="form-control" name="mmb_pwd" placeholder="กรุณากรอกรหัสผ่าน">
                                    </div>
                                    <div class="col-12">
                                        <label for=" mmb_confirm_pwd">ยืนยันรหัสผ่าน:<br>

                                        </label>
                                        <input type="password" id="mmb_confirm_pwd" class="form-control" name="mmb_confirm_pwd" placeholder="กรุณากรอกยืนยันรหัสผ่าน">
                                    </div>
                                    <div class="col-12">

                                        <select class="form-control" id="member" name="member" required hidden>
                                            <option value="1" selected>Member</option>
                                        </select>
                                    </div>


                                    <div class="col-12">
                                        <label for="mmb_addr">ที่อยู่:<br>

                                        </label>
                                        <textarea id="mmb_addr" class="form-control" name="mmb_addr" placeholder="กรุณากรอกที่อยู่"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <label for="mmb_email">อีเมล:<br>

                                        </label>
                                        <input type="email" id="mmb_email" class="form-control" name="mmb_email" placeholder="กรุณากรอกอีเมล">
                                    </div>
                                    <div class="col-12">
                                        <label for="mmb_phone">เบอร์โทรศัพท์:<br>

                                        </label>
                                        <input type="tel" id="mmb_phone" class="form-control" name="mmb_phone" placeholder="กรุณากรอกเบอร์โทรศัพท์">
                                    </div>



                                    <div class="col-12 text-center py-3">
                                        <input type="submit" name="button" id="button" class="btn btn-primary d-grid mx-auto w-100" value="สมัครสมาชิก">
                                        <a href="./">กลับหน้าหลัก</a>
                                        <p class="mt-3">มีบัญชีอยู่แล้ว? <a href="php-line-login-main/test.php">ลงชื่อเข้าใช้</a></p>
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
                window.location.href = './';
            });
        </script>
    <?php endif; ?>

</body>

</html>