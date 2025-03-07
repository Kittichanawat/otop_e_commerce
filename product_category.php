<?php
session_start(); // ตรวจสอบ Session

// ตรวจสอบว่ามี pty_id ที่ถูกส่งมาหรือไม่
if (isset($_GET['pty_id'])) {
    $pty_id = $_GET['pty_id'];

    // ต่อไปเราสามารถใช้ $mmb_username เพื่อแสดงชื่อผู้ใช้ในหน้าเว็บของคุณได้
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <!-- head -->
    <?php include('mainweb_page/head.php'); ?>

    <!-- head -->

    <body>
    <header>
        <!-- Navbar -->
        <?php include('mainweb_page/nav_bar.php'); ?>
        <!-- Navbar -->
</header>
      


        <main>

        <div class="container mt-4">
    <div class="row">
        <?php
        // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อฐานข้อมูลตามของคุณ)
        require('connect.php');

        // ดึงชื่อประเภทสินค้าจากตาราง product_type โดยใช้ $pty_id
        $pty_sql = "SELECT pty_name FROM product_type WHERE pty_id = $pty_id";
        $pty_result = $proj_connect->query($pty_sql);
        $pty_row = $pty_result->fetch_assoc();
        $pty_name = $pty_row["pty_name"];
        ?>

        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"><?php echo $pty_name; ?></h1>
                </div>
            </div>
        </section>

        <?php
        // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้าที่มี pty_id ตรงกับที่ถูกส่งมา
        $sql = "SELECT product.*, product_type.pty_id FROM product
                LEFT JOIN product_type ON product.pty_id = product_type.pty_id
                WHERE product.prd_show = 1 AND product.pty_id = $pty_id";
        $result = $proj_connect->query($sql);

        if ($result->num_rows > 0) {
            // มีรายการสินค้าในฐานข้อมูล
            while ($row = $result->fetch_assoc()) {
                // ดึงข้อมูลสินค้าแต่ละรายการ
                $prd_id = $row["prd_id"];
                $randomString = bin2hex(random_bytes(5)); // Generate a random string
                $encodedPrdId = base64_encode($prd_id . "-" . $randomString); // Encode with random element
                $prd_name = $row["prd_name"];
                $prd_desc = $row["prd_desc"];
                $prd_price = $row["prd_price"];
                $prd_img = $row["prd_img"];
                $soldOut = $row["amount"] == 0;
                $imgClass = $soldOut ? 'sold-out' : '';
                $overlay = $soldOut ? '<div class="sold-out-overlay">Sold Out</div>' : '';
                $isPromotion = $row["prd_promotion"] == 1;
                $promotionPrice = $row["price_promotion"];
                $originalPrice = $row["prd_price"];
                $discountPercentage = 0;

                // คำนวณเปอร์เซ็นต์การลดราคา
                if ($isPromotion && $promotionPrice > 0) {
                    $discountPercentage = round((($originalPrice - $promotionPrice) / $originalPrice) * 100);
                }

                // สร้าง HTML สำหรับแสดงรายการสินค้า
        ?>
            <div class="col-md-4 mb-4">
                <div class="card-popup m-3 ">
                    <a href="product_detail.php?prd_id=<?php echo $encodedPrdId; ?>">
                        <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $prd_img; ?>" class="card-img-top img-fluid img-thumbnail" alt="" data-toggle="modal" data-target="#productModal">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title text-center"><?php echo $prd_name; ?></h5>
                        <p class="card-text text-center text-muted"><i class="fa-solid fa-map-location-dot"></i> </p>
                        <p class="card-text text-center text-muted"><i class="fa-solid fa-list-ul"></i> <?php echo $pty_name; ?></p>
                        
                        <a href="product_detail.php?prd_id=<?php echo $encodedPrdId; ?>" class="btn btn-primary">รายละเอียด</a>
                        <?php
                                            if (!$soldOut && (isset($_SESSION['mmb_username']) || isset($_SESSION['line_profile']))) {
                                                // Show "Add to Cart" button only if amount is not 0 and user is logged in
                                            ?>
                                          <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="addToCart(<?php echo $row['prd_id']; ?>, <?php echo $_SESSION['mmb_id']; ?>, <?php echo $row['pty_id']; ?>, '<?php echo $row['prd_name']; ?>', <?php echo $row['prd_price']; ?>)">
    <i class="fas fa-cart-plus"></i> เพิ่มไปยังตะกร้า
</a>

                                            <?php
                                            }
                                            ?>
                    </div>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light"> <i class="fa-solid fa-circle-xmark"></i> ไม่มีสินค้าในขณะนี้ <i class="fa-solid fa-circle-xmark"></i></h1>
                </div>
            </div>
        </section>
        <?php
        }
        ?>
    </div>
</div>

        <br>
        <br>
        <br>
        </main>
        <!-- footer -->
        <?php include('mainweb_page/footer.php'); ?>

        <!-- footer -->

        <!-- end_script -->
        <?php include('mainweb_page/end_script.php'); ?>

        <!-- end_script -->

    </body>

    </html>
<?php
} else {
    echo "ไม่ได้ระบุ pty_id";
}
?>
