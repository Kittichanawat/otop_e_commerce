
<?php

require_once('php-line-login-main/LineLogin.php');

?>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header justify-content-center flex-column">
              <!-- Logo on its own line -->
              <a href="#" class="d-block mb-2">
                  <img src="assets/img/logo.png" alt="Login Logo">
              </a> 
              <!-- Title on its own line, centered -->
              <h5 class="modal-title d-block" id="loginModalLabel">เข้าสู่ระบบ</h5>
              <button type="button" class="btn-close position-absolute top-0 end-0" data-bs-dismiss="modal" aria-label="Close" style="margin-top: 12px; margin-right: 12px;"></button>
          </div>
          <div class="modal-body">
              <!-- Login form -->
              <form id="yourFormId" method="post">
                  <div class="mb-3">
                      <label for="mmb_username" class="form-label">ชื่อผู้ใช้:</label>
                      <input type="text" class="form-control" id="mmb_username" name="mmb_username" required>
                  </div>
                  <div class="mb-3">
                      <label for="mmb_pwd" class="form-label">รหัสผ่าน:</label>
                      <input type="password" class="form-control" id="mmb_pwd" name="mmb_pwd" required>
                  </div>
                  
                  <button type="submit" class="btn btn-primary w-100">เข้าสู่ระบบ</button>
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
              </form>
          </div>
          <div class="modal-footer justify-content-center ">
              <p class="text-center mt-3">สมัครสมาชิกใหม่? <a href="#" data-bs-toggle="modal" data-bs-target="#RegisterModal" >ลงทะเบียน</a></p>
          </div>
      </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
    $.validator.addMethod('strongPassword', function (value, element) {
        return this.optional(element) ||
            value.length >= 6 &&
            /\d/.test(value) &&
            /[a-z]/i.test(value);
    }, 'รหัสผ่านควรมีอย่างน้อย 6 ตัว, ประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก');

    $.validator.addMethod('alphanumeric', function (value, element) {
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
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('select2')) {
                error.insertAfter(element.next('span'));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var formData = new FormData(form);

            fetch("php-line-login-main/login_handler.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
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