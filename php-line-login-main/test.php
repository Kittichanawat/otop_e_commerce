<?php
session_start();
require_once('LineLogin.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Kanit', sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            margin-top: 100px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .social-login-btn {
            margin-top: 20px;
        }

        .social-login-btn a {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            /* White background color */

            color: #000000;
            /* Black text color */
        }

        .social-login-btn a.btn-success:hover {
            background-color: #01C301;
            color: #ffffff;
            /* Change text color when hovered */
        }

        .social-login-btn img {
            max-width: 20px;
            margin-right: 10px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-header img {
            max-width: 100px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php
    /**
     * Login Page
     *
     * @link https://appzstory.dev
     * @author Yothin Sapsamran (Jame AppzStory Studio)
     */

    require_once('../connect.php'); // Connect to the database

    if (isset($_SESSION['mmb_username']) || isset($_SESSION['line_profile'])) {
        header("Location: ../");
        exit;
    }


    ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod('strongPassword', function(value, element) {
                return this.optional(element) ||
                    value.length >= 6 &&
                    /\d/.test(value) &&
                    /[a-z]/i.test(value);
            }, 'รหัสผ่านควรมีอย่างน้อย 6 ตัว, ประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก');

            $.validator.addMethod('alphanumeric', function(value, element) {
                return this.optional(element) || /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]+$/.test(value);
            }, 'ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลข');

            $("#yourFormId").validate({
                rules: {
                    mmb_username: {
                        required: true,

                    },
                    mmb_pwd: {
                        required: true,

                    }
                },
                messages: {
                    mmb_username: {
                        required: 'โปรดกรอกข้อมูล ชื่อผู้ใช้',
                    },
                    mmb_pwd: {
                        required: 'โปรดกรอกรหัสผ่าน',
                    }
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    fetch("login_handler.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Logged in Successfully',
                                    text: 'Redirecting...',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    // Redirect based on the URL received from the server
                                    setTimeout(function() {
                                        window.location.href = data.redirectURL;
                                    }, ); // Waiting for SweetAlert timer
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Failed',
                                    text: data.errorMessage,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        });
                }
            });
        });
    </script>





    <div class="container">
        <div class="login-container">
            <div class="text-center mb-5">
                <a href="../"><img src="../assets/img/logo.png" alt="Login Logo"></a>
                <h2>ลงชื่อเข้าใช้</h2>
            </div>

            <!-- Username login -->
            <form id="yourFormId" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">ชื่อผู้ใช้:</label>
                    <input type="text" class="form-control" id="mmb_username" name="mmb_username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน:</label>
                    <input type="password" class="form-control" id="mmb_pwd" name="mmb_pwd" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
            </form>

            <!-- Social logins -->
            <div class="social-login-btn mt-3">
                <p class="text-center">หรือเข้าสู่ระบบด้วย</p>
                <!-- <a href="<?= $login_url ?>"class="btn btn-danger w-100">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEy0lEQVR4nO2ZbUwbZQDHL45M5vygycRkL0YFlWw9oHdFYSsr69uItBksIYwOwiC8KKwq4EAY8TYYsoG8CIOFCduCzmiTQbveNSC4q7p9chlkEo0fTIxrC2uPFzcXoC885sggdYP2bj1ajP0n/y9N7+nvd9fnuadXCAommGB8DsBEIdMVaB5VjBDWTPTOuFIwNy4TuCx7Y4FFGAss+wQLEwp09q4KNdsK+QNUKT8XYFAIFOj8VQ7HUQXIDUsS6jTHxwI2tcgFTlsecmO6KjrG/+DVgjeoPPS2JUHACnpFEWEssB1BRmeOo+F+gZ/6EGk2SwQLvoI/JiIWuGY+QE6vGThoittky0F+4Rrc/EhtOcgIwNI2cgo/0wk/b1UhE2sNb37YaTW/lTN4cFEUak1Hrf6CpwoQEuIyVD7ys9/g8zmGny5B2lhNRDnqpPKRm1Ml/OqpkzGiexi65X5ZVJjtGCyhSmMwKhcZpZfPVc68kVP4mVo03CITuJiCT5UgXUwmnxlDn7Ed5V9yF6G4hqczqUZ+YgJvPYyY7tfxXmQ7Pr3uWzOQ8TWBB9/v2jE/DM9PlfGBebfHJe8W0EAboPUWBwmfdhhhQPfvc9FgXPL4HdeaiZrWJTzQpG2wG3mmJQG6c7ooYFWhbt95gZMqid4GrcfYjbx4d/jlXoPBvbqYxb3LpBrphtZr7Ea4akWBh31wIXoCqJOehtZr7CR8xZOAwwi3sRnvhXwj4KrJVT1/eP1Ah5E35lGAjEoKlMBbpd/Mev1AOwlPehKYJXdGBErgtWLCxURg3pMAIHc+GyiBbYXD4H8hMOlJYO6HqNcDJRBRRCz8xyexhtEk7vOyjLYHSuDt4z0mBgK8ytXg717jg1pc9qBJk7YJ4jiNvWWbee/pnJ4E3q1v0DMQgONWgh8ZfhNk6RRA0Z8CWgziC1wLqM/Ud3u7AjXtFSqvAwEAPWU38u4sgduNMOgfEIIU7YFFeLqHdQpnx0DCDq7g61sqXo4s1rs8wUcexZ0YiTF7mucwwvU0/AwZDWpw+TK4eyuuyi0kKfL58SBGYiHJlT0Wb2c/p7b1OuNBAQlv/21YYM/TJa8Iv9QTuGzUFwmMxELSsY4xb/BbC78DNZ99hLIavA6XjnqCX74Serml+9vdW9nCdw3teSm/sfZ3JqtP2sedY2zHh3SDCa9kahUuJhKZOoWzjUjswS5mh3obt3dQtrkFl3yu0ipcqX2p4OCpVo/w4UWGBexTjNXNczkdhLhZyUDAXaROLx05axBjXxEJ4iuD8WGXSdGWHsMeYbshseYELr9Jv8f9GGVfKshqxkBYAbmiQMGpxk7Il9QTkhGmAr40u+t9sP2doX/Bp1Sf/xXyNRpN2sZjuv3jfpHozQWRav0i/L7yL6gi7CyrjeOqIUnRc5V6ucUfEoe+VoGMmlYT1omFcQLvJhF6EpfdZjMnnqS1hHTEYFjD39xdhr0Nh7RKRqsTm2Zola5zRGID5I/06kQRdbj01kG37cWTNrX/wOJZvzwkfBXydy4NCtEzuPTHHG2yg/WE1Skcn+DS61/iMv//yfdoNADacB4XH2nCxfpKXPZngTZ5NkurcNFXiN4EpmuVC/Rr5Vf3mxoICdFlSMymj4GCCSYYyNf8A50RcaYC8geEAAAAAElFTkSuQmCC">
                เข้าสู่ระบบด้วย Google
             </a> -->

                <?php
                if (!isset($_SESSION['profile'])) {
                    $line = new LineLogin();
                    $link = $line->getLink();
                ?>
                    <a href="<?php echo $link; ?>" class="btn btn-success mt-2 w-100">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAADfklEQVR4nO2ZWyisURTHV26FErmlSOSBBx6UOp3bIyl54tWLF154kgjxRq4lHS9SnBtv8nJeOHzfMIzLENI5iGE4xDDjclzmsk5r18hnnMN32cOp+deqac/stdfv25e1Zn8APvnkk08vXzp4BwJ8BQF2QQQHiICczAECmEGELyDCW/WBf4cAEOADx4DxEetiMSjW8waPtxCKNA7vX0DwyEyAN0qe/sCzBy7e2mclALtKBwzUBWLcdBymz6czo8/UpmIGzPIBZJ42WcYsbNppwunTabS77Hhf1Ebf0W/otzIhHEoAnuQ8ZzkHdTYdyhX1yV7KfjqE1gBhk2HYs9+DatWz38N8eRUgQh+BhjMDaiXjuRGjpqK8AxA8EcwG1FrGcyPzzR2gfbcdeanN3MYXIHU2FZ3o5AbgRCemzaXxA2g2N0sGXP29ig2mBklb969uHLOO4cL5AtZu1aILXax9wjaBnXudeGI/waIfRVi4Wsis/6Bf0r/F3MIPYO1yTTJY114Xhk6GStoyjZlYvlGOreZWCXTlZiV7uoJNYO25y7kMoHe/V9J//XKdD4C/zh9vXDeyASgDUwK7DzB3NofH9mN0uBweCS9AF6A9QKQ+0mPNPgYQrg/H/JV8TJ5JxpK1EgmA24p/Fnv4jZmK0R7AT/TDa9e1LADKF0f2I4w3xLOZuAtA+2HwcBC3r7Yl/WlGuMwA2dLFkgdAkC4IG3caWY1D6/c+AGncOs6W4F2Ais0K1k9/qpf4XDxf5LeJ6031ksFGraMYOxXLAqUl1nfQh6XrpWxjfjv+xpaPW5Q/6PQxXZkw0ZDI+kToI7B6q1rik8bgBpBgSMAL5wXyks1hw+ipaL6ZuGarhhtA2UYZ/1KC1vKQZUjz4AcOB/4evJYAZCETIThsGdYs+JGTkX8XcloDuI/VOlMdXjmvVAU/bBlmD+Sx8TQHcFvSTBI7fS6dl7KD79jtePjM9yaA2yjrUlalI3TlYuW2iHtIVrsVC1YLZPnnDnDfMuYzPGon0uzZLKbMpMj36W0AMovdchs4LbGqzaqnLxlRPYCqS1x3GeHO2PRnSIU/h1cvtsioxKBiLW8lT/VMggg7SmaArrjxRZgAH5UAvAIBXP/v5S6JrrafP/hOUCx6ufCcEAJ0qnvB4RZNIV1x02bi/YpJhB0Q4BOMw2v1gfvkk08+AWf9AQJ8Gub9CBjbAAAAAElFTkSuQmCC">
                        เข้าสู่ระบบด้วย Line
                    </a>
                <?php }  ?>

            </div>
            <p class="text-center mt-3">สมัครสมาชิกใหม่? <a href="../member_add.php">ลงทะเบียน</a></p>
        </div>
    </div>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <!-- Your custom JavaScript -->
    <script>
        function lineLogin() {
            // Add your Line login logic here
            alert('Login with Line clicked');
        }

        document.getElementById('normalLoginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            // Add your normal login logic here
            alert('Normal login clicked');
        });
    </script>


</body>

</html>