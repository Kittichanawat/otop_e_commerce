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

    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">ประเพณีของจังหวัดเชียงรายddd</h1>
                <!-- <p class="lead text-muted">Something short and leading about the collection below—its contents, the
                    creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it
                    entirely.</p>
                <p>
                    <a href="#" class="btn btn-primary my-2">Main call to action</a>
                    <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                </p> -->
            </div>
        </div>
    </section>
    <div class="container mt-4">
    <div class="row">
        <?php
        // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
        require('connect.php');

        // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้า
        $sql = "SELECT * FROM tradition WHERE t_show = 1";
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
           
                        <a href="tradition_detail.php?t_id=<?php echo $row['t_id']; ?>"> <img src="startbootstrap-sb-admin-2-gh-pages/pages/tradition/<?php echo $t_img; ?>" class="card-img-top img-fluid img-thumbnail"
                        alt="" data-toggle="modal" data-target="#productModal"></a>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo  $t_name ; ?></h5>
                        <!-- เพิ่มราคาสินค้าด้วยตัวอักษรหนาสีแดง -->
                        <p class="card-text text-center text-muted"><i class="fa-solid fa-map-location-dot"></i></p>
                        <a href="tradition_detail.php?t_id=<?php echo $row['t_id']; ?>" class = "btn btn-primary">รายละเอียด</a>
                       
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
            echo '<h3>ไม่มีสินค้าในขณะนี้</h3>';
            echo '</div>';
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $proj_connect->close();
        ?>
    </div>
</div>

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