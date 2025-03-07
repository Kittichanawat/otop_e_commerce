<?php
require_once('connect.php');
require_once('mainweb_page/condition.php');

?>

<?php
require_once('connect.php'); // เรียกใช้ไฟล์การเชื่อมต่อฐานข้อมูล
$sql_script = "SELECT * FROM member ";
$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$totalrows_result = mysqli_num_rows($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อสมาชิก</title>
    <style>
    /* กำหนดความกว้างของคอลัมน์ที่มีข้อความรายละเอียด */
    th:nth-child(3),
    td:nth-child(3) {
        max-width: 150px;
        /* ปรับขนาดของคอลัมน์รายละเอียด */
        white-space: nowrap;
        /* อักขระที่ยาวเกินจะไม่ขึ้นบรรทัดใหม่ */
        overflow: hidden;
        /* ซ่อนข้อความที่เกินขอบเขตของคอลัมน์ */
        text-overflow: ellipsis;
        /* แสดงเครื่องหมาย ... ถ้าข้อความยาวเกิน */
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>

<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="assets/img/logo.png" alt=""
                    style="width: 50px; margin-right: 15px; ">OTOP เชียงราย</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">หน้าแรก</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">เกี่ยวกับเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">สถานที่ท่องเที่ยว</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            ผลิตภัณฑ์
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">อาหาร</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">เครื่องดื่ม</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">เครื่องแต่งกาย</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">ติดต่อเรา</a>
                    </li>
                    <!-- Cart Icon -->
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-count" class="badge badge-danger">0</span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['mmb_id'])) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-primary  link-a" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user"></i> <?php echo $_SESSION['mmb_username']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php if ($_SESSION['status'] == "admin") { ?>
                            <li><a class="dropdown-item" href="product_show.php"><i class="fa-solid fa-list-check"></i>
                                    จัดการสินค้า</a></li>
                            <li><a class="dropdown-item" href="member_show.php"><i class="fa-solid fa-people-roof"></i>
                                    จัดการสมาชิก</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item"
                                    href="member_edit.php?mmb_id=<?php echo $_SESSION['mmb_id']; ?>"><i
                                        class="fa-solid fa-gear"></i> แก้ไขโปรไฟล์</a></li>
                            <li><a class="dropdown-item"
                                    href="password_edit.php?mmb_id=<?php echo $_SESSION['mmb_id']; ?>"><i
                                        class="fa-solid fa-lock"></i> เปลี่ยนรหัสผ่าน</a></li>
                            <li><a class="dropdown-item" href="javascript:logout();"><i
                                        class="fa-solid fa-arrow-right-from-bracket"></i> ออกจากระบบ</a></li>
                        </ul>
                    </li>
                    <?php } else { ?>
            
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>


    <a href="index.php">หน้าหลัก</a>
    <h1 class=" text-center ">รายชื่อสมาชิก</h1>
    <table class="table table-bordered  border-dark">
    <thead>
        <tr>
            <th>ชื่อ-นามสกุล</th>
            <th>ชื่อผู้ใช้</th>
            <th>ที่อยู่</th>
            <th>เบอร์โทร</th>
            <th>Admin</th>
            <th>Member</th>
            <th>แสดง</th>
            <th colspan="2"><a href="member_add.php">เพิ่มข้อมูล</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($totalrows_result > 0) {
            while ($row_result = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row_result['mmb_name'] . ' ' . $row_result['mmb_surname']; ?></td>
                    <td><?php echo $row_result['mmb_username']; ?></td>
                    <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $row_result['mmb_addr']; ?></td>
                    <td><?php echo $row_result['mmb_phone']; ?></td>
                    <td><?php echo $row_result['status'] == "admin" ? 'ใช่' : 'ไม่ใช่'; ?></td>
                    <td><?php echo $row_result['member'] == 1 ? 'ใช่' : 'ไม่ใช่'; ?></td>
                    <td><?php echo $row_result['mmb_show'] == 1 ? 'แสดง' : 'ไม่แสดง'; ?></td>
                    <td>
                        <?php
                       if ($row_result['mmb_id'] == $_SESSION['mmb_id']) {
                        echo "คุณไม่สามารถแก้ไขตัวเองได้";
                        // สามารถเพิ่มการ Redirect หรือลิงก์ไปยังหน้าอื่นตามที่คุณต้องการ
                        // หรือแสดงข้อความแจ้งเตือนเพิ่มเติม
                       
                    }else {
                        if ($row_result['status'] == "admin") {
                            echo '';
                        } else {
                            echo '<a href="member_edit_admin.php?mmb_id=' . $row_result['mmb_id'] . '">แก้ไข</a>';
                        }
                    }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($row_result['status'] == "admin") {
                            echo '';
                        } else {
                            echo '<a href="member_delete.php?mmb_id=' . $row_result['mmb_id'] . '">ลบ</a>';
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="8">ไม่มีข้อมูลสมาชิกในระบบ</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
       


</body>

</html>