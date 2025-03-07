

    <!-- Login Modal -->
    <div class="modal fade" id="RegisterModal" tabindex="-1" aria-labelledby="RegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center flex-column">
                    <!-- Logo on its own line -->
                    <a href="#" class="d-block mb-2">
                        <img src="assets/img/logo.png" alt="Login Logo">
                    </a>
                    <!-- Title on its own line, centered -->
                    <h5 class="modal-title d-block" id="RegisterModalLabel">สมัครสมาชิก</h5>
                    <button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal"
                        aria-label="Close" style="margin-top: 12px; margin-right: 12px;"></button>
                </div>
                <div class="modal-body">
                    <!-- Login form -->
                    <form id="registerForm" method="post">
                        <div class="col-12">
                            <label for="mmb_name" class="col-form-label">ชื่อจริง:</label>
                            <input type="text" class="form-control" id="mmb_name" name="mmb_name"
                                placeholder="กรุณากรอกชื่อจริง">
                        </div>
                        <div class="col-12">
                            <label for="mmb_surname" class="col-form-label">นามสกุล:</label>
                            <input type="text" class="form-control" id="mmb_surname" name="mmb_surname"
                                placeholder="กรุณากรอกนามสกุล"> </ร>
                        </div>
                        <div class="col-12">

                            <label for="mmb_username" class="col-form-label">ชื่อผู้ใช้:</label>
                            <p class="text-danger">*ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น*</p>
                            <input type="text" class="form-control" id="mmb_username" name="mmb_username"
                                placeholder="กรุณากรอกชื่อผู้ใช้">

                        </div>
                        <div class="col-12">
                            <label for="mmb_pwd">รหัสผ่าน:<br>
                                <p class="text-danger">*รหัสผ่านต้องมีอย่างน้อย 6
                                    ตัวอักษรอังกฤษและประกอบไปด้วยตัวเลข,ตัวอักษรตัวใหญ่และตัวเล็ก*</p>

                            </label>
                            <input type="password" id="mmb_pwd" class="form-control" name="mmb_pwd"
                                placeholder="กรุณากรอกรหัสผ่าน">
                        </div>
                        <div class="col-12">
                            <label for="mmb_confirm_pwd" class="col-form-label">ยืนยันรหัสผ่าน:</label>
                            <input type="text" class="form-control" id="mmb_confirm_pwd" name="mmb_confirm_pwd"
                                placeholder="กรุณากรอกยืนยันรหัสผ่าน">
                        </div>
                        <div class="col-12">

                            <select class="form-control" id="member" name="member" required hidden>
                                <option value="1" selected>Member</option>
                            </select>
                        </div>


                        <div class="col-12">
                            <label for="mmb_addr" class="col-form-label">ที่อยู่:</label>
                            <textarea id="mmb_addr" class="form-control" name="mmb_addr"
                                placeholder="กรุณากรอกที่อยู่"></textarea>
                        </div>
                        <div class="col-12">
                            <label for="mmb_email" class="col-form-label">อีเมล:</label>
                            <input type="text" class="form-control" id="mmb_email" name="mmb_email"
                                placeholder="กรุณากรอกอีเมล">
                        </div>
                        <div class="col-12">
                            <label for="mmb_phone" class="col-form-label">เบอร์โทรศัพท์:</label>
                            <input type="text" class="form-control" id="mmb_phone" name="mmb_phone"
                                placeholder="กรุณากรอกเบอร์โทรศัพท์">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-5">สมัครสมาชิก</button>
                    </form>
                </div>
                <div class="modal-footer justify-content-center flex-column">
                <p class="text-center mt-3">มีบัญชีแล้ว? <a href="#"  data-bs-toggle="modal" data-bs-target="#loginModal">ลงชื่อเข้าใช้</a></p>
                </div>
            </div>
        </div>
    </div>
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
    $("#registerForm").validate({
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
