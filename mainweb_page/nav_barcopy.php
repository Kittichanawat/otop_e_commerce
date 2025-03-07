<?php require('connect/connect.php'); ?>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="./"><img src="assets/img/logo.png" alt="" style="width: 50px; margin-right: 15px; ">OTOP เชียงราย</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./">หน้าแรก</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">เกี่ยวกับเรา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tourist.php">สถานที่ท่องเที่ยว</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tradition.php">ประเพณี</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ผลิตภัณฑ์
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="product.php">สินค้าทั้งหมด</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <?php

                        // Query to fetch product types
                        $query = "SELECT pty_id, pty_name FROM product_type WHERE pty_show = 1";
                        $result = mysqli_query($proj_connect, $query);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<li><a class="dropdown-item" href="product_category.php?pty_id=' . $row['pty_id'] . '">' . $row['pty_name'] . '</a></li>';
                                echo '<li><hr class="dropdown-divider"></li>';
                            }
                        } else {
                            echo "Error: " . mysqli_error($proj_connect);
                        }
                        ?>
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="./#contact">ติดต่อเรา</a>
                </li>
                <!-- Cart Icon -->
                <li class="nav-item">


                    <?php
                    if (isset($_SESSION['mmb_username'])) { // ตรวจสอบว่ามี session mmb_username หรือไม่
                        // ถ้ามี session mmb_username ให้แสดงปุ่ม "เพิ่มไปยังตะกร้า"
                    ?>
                        <a href="cart.php" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cartItemCount" class="badge bg-danger">0</span>
                        </a>

                    <?php
                    } // ปิดเงื่อนไข
                    ?>
                </li>
                <?php if (isset($_SESSION['mmb_id'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary  link-a" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user"></i> <?php echo $_SESSION['mmb_username']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php if ($_SESSION['status'] == "superadmin" || $_SESSION['status'] == "admin") { ?>
    <li><a class="dropdown-item" href="startbootstrap-sb-admin-2-gh-pages/pages/dashboard/"><i class="fa-solid fa-house"></i> จัดการระบบหลังบ้าน</a></li>
<?php } ?>
                            <li><a class="dropdown-item" href="profile.php?mmb_id=<?php echo $_SESSION['mmb_id']; ?>"><i class="fa-solid fa-user"></i> ประวัติส่วนตัว</a></li>
                            <li><a class="dropdown-item" href="member_edit.php?mmb_id=<?php echo $_SESSION['mmb_id']; ?>"><i class="fa-solid fa-gear"></i> แก้ไขโปรไฟล์</a></li>
                            <li><a class="dropdown-item" href="password_edit.php?mmb_id=<?php echo $_SESSION['mmb_id']; ?>"><i class="fa-solid fa-lock"></i> เปลี่ยนรหัสผ่าน</a></li>
                            <li><a class="dropdown-item" href="javascript:logout();"><i class="fa-solid fa-arrow-right-from-bracket"></i> ออกจากระบบ</a></li>
                        </ul>
                    </li>

                <?php } else { ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="php-line-login-main/test.php">เข้าสู่ระบบ</a>
                        <a class="btn btn-outline-warning" href="member_add.php">สมัครสมาชิก</a>
                    </li>
                <?php }  ?>

            </ul>
        </div>
    </div>
</nav>