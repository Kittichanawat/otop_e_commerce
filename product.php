<?php
session_start(); // ตรวจสอบ Session

require('connect.php');
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
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">สินค้า OTOP จังหวัดเชียงราย</h1>
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

        <!-- test section -->

 
        <!-- Main Content -->
        <div class="container mt-4">
            <div class="row">
                <?php
             


                // ส่งคำสั่ง SQL ไปดึงข้อมูลสินค้า
                
// Define the number of products per page
$productsPerPage = 5;

// Calculate the total number of products
$totalSql = "SELECT COUNT(prd_id) AS total FROM product WHERE prd_show = 1";
$totalResult = $proj_connect->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalProducts = $totalRow['total'];

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);

// Get the current page number from the URL, defaulting to page 1 if not present
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the query
$offset = ($currentPage - 1) * $productsPerPage;

// Modify the query to fetch a subset of products
$sql = "SELECT * FROM product WHERE prd_show = 1 LIMIT $offset, $productsPerPage";
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
                        $soldOut = $row["amount"] == 0;
                        $imgClass = $soldOut ? 'sold-out' : '';
                        $overlay = $soldOut ? '<div class="sold-out-overlay">Sold Out</div>' : '';
                        $isPromotion = $row["prd_promotion"] == 1;
                        $isRecommended = $row["prd_reccom"] == 1;
                        $isPromotion = $row["prd_promotion"] == 1;
                        $promotionPrice = $row["price_promotion"];
                        $discountPercentage = 0;

                        // Calculate discount percentage if on promotion
                        if ($isPromotion && $promotionPrice > 0) {
                            $discountPercentage = round((($prd_price - $promotionPrice) / $prd_price) * 100);
                        }
                        // สร้าง HTML สำหรับแสดงรายการสินค้า
                ?>
                        <div class="col-md-4 mb-4">
                            <div class="card-popup m-3">
                                <div class="card-img-container">
                                    <?php if ($soldOut) { ?>
                                        <div class="sold-out-overlay">สินค้าหมด</div>
                                    <?php } ?>
                                    <?php if ($isRecommended) : ?>
                                        <span class="badge bg-danger position-absolute">สินค้าแนะนำ</span>
                                    <?php endif; ?>
                          
                                  <a href="product_detail.php?prd_id=<?php echo base64_encode($row['prd_id']); ?>"><img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $prd_img; ?>" class="card-img-top img-fluid " alt="<?php echo $prd_name; ?>" data-toggle="modal" data-target="#productModal<?php echo $prd_id; ?>"></a>  
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $prd_name; ?></h5>




                                    <?php if ($isPromotion && $promotionPrice > 0) : ?>
                                        <!-- แสดงเปอร์เซ็นต์การลดราคา -->

                                        <!-- แสดงราคาโปรโมชั่นและขีดค่าราคาเดิม -->
                                        <p class="card-text">
                                         

                                            <div class="badge bg-danger "><h6>-<?php echo $discountPercentage; ?>%</h6></div>        <span class=" fs-4">฿<?php echo number_format($promotionPrice, 2); ?></span>
                                            <del class="text-muted">฿<?php echo number_format($prd_price, 2); ?> </del>
                                        </p>
                                    <?php else : ?>
                                        <!-- แสดงราคาปกติ -->
                                        <p class="card-text fs-4">฿ <?php echo number_format($prd_price, 2); ?> </p>
                                    <?php endif; ?>

                                    <a class="btn btn-primary" data-toggle="modal" href="product_detail.php?prd_id=<?php echo base64_encode($row['prd_id']); ?>">ดูรายละเอียด</a>


                                    <?php
                                    if (!$soldOut && (isset($_SESSION['mmb_username']) || isset($_SESSION['line_profile']))) { // ตรวจสอบว่ามี session mmb_username หรือไม่
                                        // ถ้ามี session mmb_username ให้แสดงปุ่ม "เพิ่มไปยังตะกร้า"
                                    ?>

                                        <a href="javascript:void(0);" class="btn btn-outline-primary" onclick="addToCart(<?php echo $row['prd_id']; ?>, <?php echo $_SESSION['mmb_id']; ?>, <?php echo $row['pty_id']; ?>, '<?php echo $row['prd_name']; ?>', <?php echo $row['prd_price']; ?>)">
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


        <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center" id="pagination-container">
        <!-- JavaScript จะเพิ่มลิงก์หน้าต่างๆ ที่นี่ -->
    </ul>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const totalPages = <?php echo $totalPages; ?>;
        const currentPage = <?php echo $currentPage; ?>;
        const container = document.getElementById('pagination-container');

        // สร้างและเพิ่มปุ่ม "Previous"
        const liPrev = document.createElement('li');
        liPrev.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
        const aPrev = document.createElement('a');
        aPrev.className = 'page-link';
        aPrev.href = `?page=${currentPage - 1}`;
        aPrev.innerText = 'Previous';
        liPrev.appendChild(aPrev);
        container.appendChild(liPrev);

        // สร้างลิงก์หน้าต่างๆ
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item' + (i === currentPage ? ' active' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = `?page=${i}`;
            a.innerText = i;
            li.appendChild(a);
            container.appendChild(li);
        }

        // สร้างและเพิ่มปุ่ม "Next"
        const liNext = document.createElement('li');
        liNext.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
        const aNext = document.createElement('a');
        aNext.className = 'page-link';
        aNext.href = `?page=${currentPage + 1}`;
        aNext.innerText = 'Next';
        liNext.appendChild(aNext);
        container.appendChild(liNext);
    });
</script>

    </main>
    <!-- footer -->

    <?php include('mainweb_page/footer.php'); ?>

    <!-- footer -->


    <!-- end_script -->

    <?php include('mainweb_page/end_script.php'); ?>
    <!-- end_script -->


</body>

</html>