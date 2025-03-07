<?php
        require 'connect_cart/connect.php';
        /** ดึงข้อมูลสินค้า */
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

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
    ?>
<div class="row">
            <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div class="col-md-6 mb-4">
                    <div class="shadow rounded p-3 bg-body h-100">
                        <div class="row">
                            <div class="col-lg-5 mb-3 mb-lg-0">
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $row['prd_img'] ?>" class="img-cover" alt="AppzStory">
                                </div>
                            </div>
                            <div class="col-lg-7 ps-lg-0">
                            <div class="card-body text-center text-lg-start p-0">
                                <h5 class="card-title"><?php echo $row['prd_name'] ?></h5>
                                <div class="rate mb-3">
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                    <i class="fas fa-star text-danger"></i>
                                </div>
                                <div class="card-text">
                                    <div class="variants mb-5">
                                        <p><?php echo $row['prd_name'] ?></p>
                                    </div>
                                </div>
                                <div class="card-price d-flex align-items-center justify-content-between">
                                    <span class="fw-bold text-danger">฿<?php echo number_format($row['prd_price'],2) ?></span>
                                    <a href="updatecart.php?prd_id=<?php echo $row['prd_id'] ?>" class="btn btn-outline-primary" type="button">
                                        <i class="fas fa-cart-plus"></i> เพิ่มไปยังตะกร้า
                                    </a>
                                    <a class="btn btn-primary" data-toggle="modal"
                        href="product_detail.php?prd_id=<?php echo $row['prd_id']; ?>">ดูรายละเอียด</a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>