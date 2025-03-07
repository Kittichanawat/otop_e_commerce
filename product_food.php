<?php
session_start(); // ตรวจสอบ Session


// ต่อไปเราสามารถใช้ $mmb_username เพื่อแสดงชื่อผู้ใช้ในหน้าเว็บของคุณได้
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTOP จังหวัดเชียงใหม่</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>
    <!-- Navbar -->

    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">OTOP เชียงใหม่</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">หน้าแรก</a>
                    </li>
                    <!-- Dropdown for "สินค้า" -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProducts" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            สินค้า
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownProducts">
                            <a class="dropdown-item" href="#">สินค้า 1</a>
                            <a class="dropdown-item" href="#">สินค้า 2</a>
                            <a class="dropdown-item" href="#">สินค้า 3</a>
                            <!-- Add more product items here -->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">เกี่ยวกับเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ติดต่อเรา</a>
                    </li>

                    <?php if (isset($_SESSION['mmb_id'])) {?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://img.icons8.com/ios-glyphs/30/null/user--v1.png" />
                            <?php echo $_SESSION['mmb_username']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="javascript:logout();"><img
                                        src="https://img.icons8.com/ios-glyphs/30/null/logout-rounded--v1.png" />ออกจากระบบ</a>
                            </li>
                        </ul>
                    </li>
                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="badge badge-danger">0</span>
                        </a>
                    </li>
                    <?php } else {?>
                    <li class="nav-item">

                        <a class="btn btn-outline-primary" href="login.php">เข้าสู่ระบบ </a>
                        <a class="btn btn-outline-warning" href="member_add.php">สมัครสมาชิก</a>
                    </li>

                    <?php }?>
                </ul>
            </div>
        </div>
    </nav>





    <!-- Banner -->
    <div class="banner">
        <!-- Banner content can be added here if needed -->
    </div>

    <!-- This is header section -->
    <div class="text-center m-5 ">
        <h1>สินค้าแนะนำ</h1>
    </div>
    <!-- Main Content -->
    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <?php
    // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
    require('connect.php');

    // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้า
    $sql = "SELECT * FROM product";
    $result = $proj_connect->query($sql);
      /** เพิ่มข้อมูลสินค้าลงในตะกร้าแล้วหรือไม่ */
      if(isset($_GET['cart']) && ($_GET['cart'] == 'success')){
        echo "<script>
                Swal.fire({
                    text: 'คุณได้ทำการเพิ่มสินค้าลงในตะกร้าแล้ว',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                })
                window.history.replaceState(null, null, window.location.pathname)
            </script>";
    }

    if ($result->num_rows > 0) {
      // มีรายการสินค้าในฐานข้อมูล
      while ($row = $result->fetch_assoc()) {
        // ดึงข้อมูลสินค้าแต่ละรายการ
        $prd_id = $row["prd_id"];
        $prd_name = $row["prd_name"];
        $prd_desc = $row["prd_desc"];
        $prd_price = $row["prd_price"];
        $prd_img = $row["prd_img"];

        // สร้าง HTML สำหรับแสดงรายการสินค้า
        ?>
            <div class="col-md-4 mb-4">
                <div class="card m-3">
                    <img src="<?php echo $prd_img; ?>" class="card-img-top" alt="<?php echo $prd_name; ?>"
                        data-toggle="modal" data-target="#productModal<?php echo $prd_id; ?>">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo $prd_name; ?></h5>
                        <!-- เพิ่มราคาสินค้าด้วยตัวอักษรหนาสีแดง -->
                        <h3 class="card-text text-center text-warning fw-bold"><?php echo $prd_price; ?> THB</h3>
                        <p class="card-text"><?php echo $prd_desc; ?></p>
                        <a href="#" class="btn btn-primary" data-toggle="modal"
                            data-target="#productModal<?php echo $prd_id; ?>">ดูรายละเอียด</a>
                        <a href="updatecart.php?prd_id=<?php echo $prd_id; ?>" class="btn btn-primary"
                            onclick="addToCart()">เพิ่มสินค้าลงในตะกร้า</a>
                    </div>
                </div>
            </div>




            <!-- Modal สำหรับแสดงรายละเอียดสินค้า -->
            <div class="modal fade" id="productModal<?php echo $prd_id; ?>" tabindex="-1" role="dialog"
                aria-labelledby="productModal<?php echo $prd_id; ?>Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModal<?php echo $prd_id; ?>Label">
                                <?php echo $prd_name; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img src="<?php echo $prd_img; ?>" class="img-fluid" alt="<?php echo $prd_name; ?>">
                            <p><?php echo $prd_desc; ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
      }
    } else {
      // ไม่มีรายการสินค้าในฐานข้อมูล
      echo '<div class="col-md-12 text-center">';
      echo '<p>ไม่มีสินค้าในขณะนี้</p>';
      echo '</div>';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $proj_connect->close();
    ?>
        </div>
    </div>
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <div class="row">
                <!-- Logo -->
                <div class="col-md-3">
                    <img src="logo.png" alt="Logo" class="img-fluid">
                </div>
                <!-- About -->
                <div class="col-md-3">
                    <h5>About Us</h5>
                    <p>รายละเอียดเกี่ยวกับบริษัทหรือธุรกิจของคุณที่นี่</p>
                </div>
                <!-- Contact -->
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <p>ที่อยู่: 123 ถนนเชียงใหม่ ตำบลเมือง อำเภอเมืองเชียงใหม่ จังหวัดเชียงใหม่ 50000</p>
                    <p>เบอร์โทร: 012-345-6789</p>
                </div>
                <!-- Social Media -->
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="d-flex justify-content-center">
                        <a href="#" class="btn btn-outline-light mx-2">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light mx-2">
                            <i class="fab fa-line"></i>
                        </a>
                        <a href="#" class="btn btn-outline-light mx-2">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Link Bootstrap JS and jQuery -->
    <script>
    var cartItems = 0; // ตัวแปรสำหรับจำนวนสินค้าในตะกร้า

    // Function เพิ่มสินค้าในตะกร้า
    function addToCart() {
        cartItems++; // เพิ่มจำนวนสินค้า
        updateCartCount(); // อัปเดตจำนวนในตะกร้า
    }

    // Function ลบสินค้าในตะกร้า
    function removeFromCart() {
        if (cartItems > 0) {
            cartItems--; // ลบจำนวนสินค้า
            updateCartCount(); // อัปเดตจำนวนในตะกร้า
        }
    }

    // Function อัปเดตจำนวนสินค้าในตะกร้าและแสดงผลบนเว็บ
    function updateCartCount() {
        document.getElementById('cart-count').textContent = cartItems;
    }
    </script>
  
  <!-- function logout -->
    <script>
    function logout() {
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'ออกจากระบบสำเร็จ',
            showConfirmButton: false,
            timer: 1500
        }).then((result) => {
            if (result) {
                window.location.href = 'logout.php';
            }
        })
    }
    </script>

    <!-- add cart function -->

    <script>
    function addToCart() {
        // สร้างแจ้งเตือน SweetAlert
        Swal.fire({
            icon: 'success', // ประเภทของแจ้งเตือน (success, error, warning, info, question)
            title: 'สินค้าถูกเพิ่มในตะกร้าแล้ว',
            text: 'คุณเพิ่มสินค้าลงในตะกร้าสำเร็จ',
            confirmButtonText: 'ตกลง' // ข้อความบนปุ่ม OK
        });
    }
</script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>