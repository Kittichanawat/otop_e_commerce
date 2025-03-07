<!DOCTYPE html>
<html lang="en">
<?php include('mainweb_page/head.php');
    ?>
<body>
    <header>
        <!-- ส่วนหัวเว็บไซต์ -->
        <?php include('mainweb_page/nav_bar.php');
    ?>
    <!-- <div id="banner" class="rounded-lg-3 img-fluid  ">
        <!-- รายละเอียดอื่น ๆ ของเนื้อหาที่คุณต้องการใส่ใน Banner -->
    <!--  </div> -->

    <!-- banner -->
    <?php include('mainweb_page/banner.php');
    ?>
    <!-- banner -->
 
    </header>
    <main>
        <!-- เนื้อหาหลักของหน้าเว็บ -->
  
        <?php


$sql = "SELECT * FROM history WHERE h_show = 1"; // ดึงข้อมูลจากตาราง history ที่มี h_show เท่ากับ 1
$result = $proj_connect->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ดึงข้อมูลแต่ละแถวและแสดงใน HTML
        $h_title = $row['h_title'];
        $h_detail = $row['h_detail'];
        $h_img = $row['h_img'];
        $h_link = $row['h_link'];
?>
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <a href="<?php echo $h_link; ?>"><img src="startbootstrap-sb-admin-2-gh-pages/pages/history/<?php echo $h_img; ?>" class="d-block mx-lg-auto img-fluid rounded-lg-3 shadow-lg" alt="Bootstrap Themes" width="700" height="500" loading="lazy"></a>
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-3"><?php echo $h_title; ?></h1>
                    <p class="lead"><?php echo $h_detail; ?></p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="<?php echo $h_link; ?>" target="_blank" class="btn btn-primary btn-lg px-4 me-md-2">More
                            info</a>
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




<!-- This is header section -->
<div class="text-center m-5 ">
    <h1>สินค้าแนะนำ</h1>
</div>
<!-- test section -->


<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <?php
        // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)


        // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้า
        $sql = "SELECT * FROM product WHERE prd_show = 1 AND prd_reccom = 1";

        $result = $proj_connect->query($sql);

        if ($result->num_rows > 0) {
            // มีรายการสินค้าในฐานข้อมูล
            while ($row = $result->fetch_assoc()) {
                // ดึงข้อมูลสินค้าแต่ละรายการ
                $prd_id = $row["prd_id"];
                $prd_name = $row["prd_name"];
                $prd_desc = $row["prd_desc"];
                $prd_price = $row["prd_price"];
                $prd_img = $row["prd_img"];
                $pty_id = $row["pty_id"];

                // สร้าง HTML สำหรับแสดงรายการสินค้า
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card m-3">
                        <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $prd_img; ?>" class="card-img-top img-fluid img-thumbnail" alt="<?php echo $prd_name; ?>" data-toggle="modal" data-target="#productModal<?php echo $prd_id; ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo $prd_name; ?></h5>
                            <!-- เพิ่มราคาสินค้าด้วยตัวอักษรหนาสีแดง -->
                            <h3 class="text-center text-warning fw-bold">
                                <?php echo number_format($prd_price, 0, '.', ','); ?> THB</h3>

                            <a class="btn btn-primary" data-toggle="modal" href="product_detail.php?prd_id=<?php echo $row['prd_id']; ?>">ดูรายละเอียด</a>

                            <?php
                            if (isset($_SESSION['mmb_username'])) { // ตรวจสอบว่ามี session mmb_username หรือไม่
                                // ถ้ามี session mmb_username ให้แสดงปุ่ม "เพิ่มไปยังตะกร้า"
                            ?>
                                <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="addToCart(<?php echo $row['prd_id']; ?>, <?php echo $_SESSION['mmb_id']; ?>, <?php echo $row['pty_id']; ?>)">
                                    <i class="fas fa-cart-plus"></i> เพิ่มไปยังตะกร้า
                                </a>
                            <?php
                            } // ปิดเงื่อนไข
                            ?>
                            <!-- <a href="updatecart.php?prd_id=<?php echo $row['prd_id'] ?>" class="btn btn-outline-primary" type="button">
                                    <i class="fas fa-cart-plus"></i> เพิ่มไปยังตะกร้า
                                </a> -->





                        </div>
                    </div>
                </div>
           
        




<?php
            }
        } else {
            // ไม่มีรายการสินค้าในฐานข้อมูล
            echo '<div class="col-md-12 text-center mb-5">';
            echo '<h3>ไม่มีสินค้าในขณะนี้</h3>';
            echo '</div>';
        }

        // // ปิดการเชื่อมต่อฐานข้อมูล

?>
           </div>
       </div>
    </div>
</div>










<div class="text-center m-5 ">
<h1>สถานที่ท่องเที่ยวแนะนำในจังหวัดเชียงราย</h1>
</div>
<div class="container mt-4">
<div class="row">
    <?php
    // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
    require('connect.php');

    // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้า
    $sql = "SELECT * FROM tourist WHERE p_show = 1 AND p_reccom = 1";

    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        // มีรายการสินค้าในฐานข้อมูล
        while ($row = $result->fetch_assoc()) {
            // ดึงข้อมูลสินค้าแต่ละรายการ
            $p_id = $row["p_id"];
            $p_name = $row["p_name"];
            $p_des = $row["p_des"];
            $p_addr = $row["p_addr"];
            $p_img = $row["p_img"];
            $time = $row["time"];

            // สร้าง HTML สำหรับแสดงรายการสินค้า
    ?>
            <div class="col-md-4 mb-4">
                <div class="card m-3">

                    <a href="tourist_detail.php?p_id=<?php echo $row['p_id']; ?>"> <img src="startbootstrap-sb-admin-2-gh-pages/pages/tourist/<?php echo $p_img; ?>" class="card-img-top img-fluid img-thumbnail" alt="" data-toggle="modal" data-target="#productModal"></a>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo  $p_name; ?></h5>
                        <!-- เพิ่มราคาสินค้าด้วยตัวอักษรหนาสีแดง -->
                        <p class="card-text text-center text-muted"><i class="fa-solid fa-map-location-dot"></i>
                            <?php echo $p_addr; ?></p>
                        <!-- <p class="card-text text-center text-muted"><i class="fa-solid fa-calendar-days"></i> <?php echo $time; ?></p> -->
                        <a href="tourist_detail.php?p_id=<?php echo $row['p_id']; ?>" class="btn btn-primary">รายละเอียด</a>

                        <!-- เพิ่มปุ่ม "รายละเอียด" ที่เรียก Modal -->

                        <!-- เพิ่มปุ่ม "เพิ่มสินค้าลงในตะกร้า" (ตามความเหมาะสม) -->
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        // ไม่มีรายการสินค้าในฐานข้อมูล
        echo '<div class="col-md-12 text-center mb-5">';
        echo '';
        echo '</div>';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล

    ?>
</div>
</div>
</div>
</div>


<div class="text-center m-5 ">
<h1>ประเพณีที่น่าสนใจของจังหวัดเชียงราย</h1>
</div>
<div class="container mt-4">
<div class="row">
    <?php
    // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
    require('connect.php');

    // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้า
    $sql = "SELECT * FROM tradition WHERE t_show = 1 AND t_reccom = 1";

    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        // มีรายการสินค้าในฐานข้อมูล
        while ($row = $result->fetch_assoc()) {
            // ดึงข้อมูลสินค้าแต่ละรายการ
            $t_id = $row["t_id"];
            $t_name = $row["t_name"];
            $t_detail = $row["t_detail"];

            $t_img = $row["t_img"];


            // สร้าง HTML สำหรับแสดงรายการสินค้า
    ?>
            <div class="col-md-4 mb-4">
                <div class="card m-3">

                    <a href="tradition_detail.php?t_id=<?php echo $row['t_id']; ?>"> <img src="startbootstrap-sb-admin-2-gh-pages/pages/tradition/<?php echo $t_img; ?>" class="card-img-top img-fluid img-thumbnail" alt="" data-toggle="modal" data-target="#productModal"></a>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo  $t_name; ?></h5>
                        <!-- เพิ่มราคาสินค้าด้วยตัวอักษรหนาสีแดง -->
                        <!-- <p class="card-text text-center text-muted"><i class="fa-solid fa-map-location-dot"></i> <?php echo $t_addr; ?></p> -->
                        <!-- <p class="card-text text-center text-muted"><i class="fa-solid fa-calendar-days"></i> <?php echo $time; ?></p> -->
                        <a href="tradition_detail.php?t_id=<?php echo $row['t_id']; ?>" class="btn btn-primary">รายละเอียด</a>

                        <!-- เพิ่มปุ่ม "รายละเอียด" ที่เรียก Modal -->

                        <!-- เพิ่มปุ่ม "เพิ่มสินค้าลงในตะกร้า" (ตามความเหมาะสม) -->
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        // ไม่มีรายการสินค้าในฐานข้อมูล
        echo '<div class="col-md-12 text-center mb-5">';
        echo '<h3>ไม่มีข้อมูล</h3>';
        echo '</div>';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล

    ?>
    </div>
 </div>
</div>
</div>







<!-- <section id="contactus" class="container py-5">
<h2>Contact Us</h2>
<div class="row">
    <div class="col-md-6">
        <h3>Contact Information</h3>
        <p><strong>Name:</strong> John Doe</p>
        <p><strong>Address:</strong> 123 Main Street, City, Country</p>
        <p><strong>Phone:</strong> +1 (123) 456-7890</p>
    </div>
    <div class="col-md-6">
        <h3>Map</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7505.485588741909!2d100.45368!3d19.850833!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d7d1e799a4c53f%3A0xdbf94fb33f550990!2sPhu%20Chi%20Fah%20viewpoint!5e0!3m2!1sth!2sus!4v1697367083541!5m2!1sth!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
</section> -->



<?php


// คำสั่ง SQL เพื่อดึงข้อมูลที่มีหัวข้อเป็น "Contact Us" และจัดเรียงข้อมูลใน column 'detail'
$sql = "SELECT * FROM contact WHERE pages_show = 1";

$result = mysqli_query($proj_connect, $sql);

if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$details = explode("\r\n", $row['detail']); // แยกข้อมูลใน 'detail' โดยใช้ "\r\n" เป็นตัวแยก

// ตรวจสอบและแสดงข้อมูลที่แยกออกมา
if (!empty($details)) {
?>


    <div class="container mt-5" id="contact">
        <div class="row" id="contact">
            <div class="col-md-6 offset-md-3 mb-4">
                <h1 class="text-center"><?php echo $row['title']; ?></h1>

                <ul class="list-group">
                    <?php
                    foreach ($details as $detail) {
                        if (!empty(trim($detail))) {
                    ?>
                            <li class="list-group-item">
                                <strong><i class="fa-solid fa-check"></i></strong>
                                <?php echo $detail; ?>
                            </li>
                    <?php
                        }
                    }
                    ?>
                </ul>


            </div>
        </div>
    </div>
    <div class="container text-center">
        <img src="startbootstrap-sb-admin-2-gh-pages/pages/contact/<?php echo $row['img']; ?>" alt="" width="700px" height="500px" class=" rounded-lg-3 shadow-lg text-center">
    </div>




<?php
} else {
    echo "ไม่พบข้อมูล Contact";
}
} else {
echo "ไม่พบข้อมูล Contact Us";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
// $proj_connect->close();
?>
   </div>
</div>
</div>


    </main>
  
    <?php include('mainweb_page/footer.php');?>
   <?php include('mainweb_page/end_script.php');?>
</body>
</html>
