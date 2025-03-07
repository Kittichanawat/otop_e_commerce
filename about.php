<?php
session_start(); // ตรวจสอบ Session

require('connect.php');
// ต่อไปเราสามารถใช้ $mmb_username เพื่อแสดงชื่อผู้ใช้ในหน้าเว็บของคุณได้
?>
<!DOCTYPE html>
<html lang="en">


<!-- head -->
<?php include ('mainweb_page/head.php');?>

<!-- head -->

<body>
    <header>
        <!-- Navbar -->
        <?php include ('mainweb_page/nav_bar.php');?>
        <!-- Navbar -->





    </header>

    <main>
        <?php
 

$sql = "SELECT * FROM about WHERE a_show = 1"; // ดึงข้อมูลจากตาราง history ที่มี h_show เท่ากับ 1
$result = $proj_connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ดึงข้อมูลแต่ละแถวและแสดงใน HTML
        $a_title = $row['a_title'];
        $a_detail = $row['a_detail'];
        $a_img = $row['a_img'];
        $a_link = $row['a_link'];
        ?>
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <a href="<?php echo $a_link; ?>"><img
                            src="startbootstrap-sb-admin-2-gh-pages/pages/about/<?php echo $a_img; ?>"
                            class="d-block mx-lg-auto img-fluid rounded-lg-3 shadow-lg" alt="Bootstrap Themes"
                            width="700" height="500" loading="lazy"></a>
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-3"><?php echo $a_title; ?></h1>
                    <p class="lead"><?php echo $a_detail; ?></p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <!-- <a href="<?php echo $a_link; ?>" target="_blank" class="btn btn-primary btn-lg px-4 me-md-2">More info</a> -->
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "ไม่พบข้อมูลประวัติ";
}
?>


    </main>
    <!-- Login Modal -->
    <?php include('mainweb_page/login_modal.php'); ?>
    <!-- footer -->

    <?php include ('mainweb_page/footer.php');?>

    <!-- footer -->


    <!-- end_script -->

    <?php include ('mainweb_page/end_script.php');?>
    <!-- end_script -->


</body>

</html>