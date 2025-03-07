<!DOCTYPE html>
<html lang="en">

<?php include('mainweb_page/head.php');
?>

<body>
    <div class="flex-container">
        <div class="container py-3">

            <nav class="navbar navbar-light  border-0 shadow-sm rounded-3 mb-4">
                <div class="container-fluid">
                    <a href="./" aria-current="page" class="navbar-brand">
                        <span class="brand-center">
                            <img src="assets/img/logo.png" width="50px" class="me-2">
                            <span class="d-none d-md-block"> OTOP เชียงราย </span>
                        </span>
                    </a>
                    <span class="text-end position-relative">
                        <div class="btn-group">
                            <a href="product.php" class="btn btn-outline-secondary">เพิ่มรายการสินค้า</a>
                        </div>
                    </span>
                </div>
            </nav>

            <h1 class="text-center my-3">ตะกร้าสินค้า</h1>

            <div class="container">
                <?php
        // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อตามของคุณ)
        require('connect/connect.php');

        // ตรวจสอบว่าผู้ใช้ลงชื่อเข้าใช้หรืออาจจะมีการใช้ระบบเซสชันในการจดจำรายการสินค้า
        session_start();

        if (isset($_SESSION['mmb_id'])) {
            // ดึงรายการสินค้าที่อยู่ในตะกร้าของผู้ใช้ปัจจุบัน
            $mmb_id = $_SESSION['mmb_id'];
            $sql = "SELECT cart.crt_id, product.prd_id, product.prd_name, product.prd_price, product.price_promotion, product.prd_img, cart.crt_amount
            FROM cart 
            INNER JOIN product ON cart.prd_id = product.prd_id 
            WHERE cart.mmb_id = $mmb_id";
            $result = $proj_connect->query($sql);

            if ($result->num_rows > 0) {
        ?>
        
        <table class="table">
    <thead>
        <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">รูปสินค้า</th>
            <th scope="col">ชื่อสินค้า</th>
            <th scope="col">ราคา</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ราคารวม</th>
            <th scope="col">การจัดการ</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totalPrice = 0;
        $itemNumber = 1;

        while ($row = $result->fetch_assoc()) {
            $cart_id = $row['crt_id'];
            $prd_name = $row['prd_name'];
            $prd_id = $row['prd_id'];
            $prd_price = $row['prd_price'];
            $prd_img = $row['prd_img'];
            $crt_amount = $row['crt_amount'];
           
               // Check if the product has a promotional price
               $isPromotion = $row['price_promotion'] > 0;
               $priceUsedForCalculation = $isPromotion ? $row['price_promotion'] : $row['prd_price'];
       
               $itemTotal = $priceUsedForCalculation * $crt_amount;
               $totalPrice += $itemTotal;
       



        
            ?>
            <tr data-cart-id="<?php echo $cart_id; ?>">
                <td><?php echo $itemNumber; ?></td>
                <td>
                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $prd_img; ?>"
                        alt="<?php echo $prd_name; ?>" class="img-fluid" style="max-width: 100px;">
                </td>
                <td><?php echo $prd_name; ?></td>
                <td><?php echo $isPromotion ? $row['price_promotion'] : $row['prd_price']; ?> บาท</td>
                <td>
                    <button class="btn btn-secondary" onclick="updateCartItem(<?php echo $cart_id; ?>, 'decrease', true)">-</button>
                    <span id="crt_amount_<?php echo $cart_id; ?>"><?php echo $crt_amount; ?></span>
                    <button class="btn btn-secondary" onclick="updateCartItem(<?php echo $cart_id; ?>, 'increase', true)">+</button>
                </td>
                <td><span id="item_total_<?php echo $cart_id; ?>"><?php echo $itemTotal; ?> บาท</span></td>
                <td>
                    <button class="btn btn-danger" onclick="removeCartItem(<?php echo $cart_id; ?>)">ลบ</button>
                </td>
            </tr>
            <?php
            $itemNumber++;
        }
        ?>

        <tr>
            <td colspan="4">ราคารวม</td>
            <td id="total_price"><?php echo $totalPrice; ?> บาท</td>
            <td></td>
        </tr>
    </tbody>
</table>

                <div class="text-center">

               
<a href="#" onclick="redirectToCheckout(); return false;" class="btn btn-primary">ไปหน้าชำระเงิน</a>




                </div>
                
                <?php
            } else {
                // ถ้าไม่มีสินค้าในตะกร้า
                echo '<p class="text-center my-3">ไม่มีสินค้าในตะกร้าของคุณ</p>';
            }
        } else {
            // ถ้าผู้ใช้ไม่ได้ลงชื่อเข้าใช้
            echo '<p class="text-center my-3">โปรดลงชื่อเข้าใช้เพื่อดูตะกร้าสินค้าของคุณ</p>';
        }
        ?>
            </div>
            <p class="author fw-bolder text-secondary text-center">
                OTOP <span class="text-pink fs-3" style="vertical-align: sub;"></span>เชียงราย
            </p>
         </div>
       </div>
      </div>
    </div>

    <script>
    function redirectToCheckout() {
        // ดึงข้อมูลของทุกสินค้าในตะกร้า
        var cartItems = document.querySelectorAll('tr[data-cart-id]');
        var cartData = [];

        // ตรวจสอบว่าตะกร้ามีสินค้าหรือไม่
        if (cartItems.length === 0) {
            alert('ไม่มีสินค้าในตะกร้า');
            return; // ออกจากฟังก์ชันถ้าไม่มีสินค้า
        }

        cartItems.forEach(function (item) {
            var cartId = item.dataset.cartId;
            var crtAmount = document.getElementById('crt_amount_' + cartId).innerText;
            var prdId = item.querySelector('td:nth-child(1)').innerText;
            var totalPrice = document.getElementById('item_total_' + cartId).innerText;

            cartData.push({
                cartId: cartId,
                crtAmount: crtAmount,
                prdId: prdId,
                totalPrice: totalPrice
            });
        });

        // สร้าง URL ที่มีพารามิเตอร์สำหรับทุกสินค้า
        var url = 'checkout_copy.php?';

        // ลบอักขระ & ที่ต่อท้าย URL
        url = url.slice(0, -1);

        // เข้ารหัส URL
        url = encodeURI(url);

        // Redirect ไปยังหน้า Checkout
        window.location.href = url;
    }
</script>




<script>
function updateCartItem(cartId, action, reloadPage) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_cart_item.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                var crtAmountElement = document.getElementById('crt_amount_' + cartId);
                var itemTotalElement = document.getElementById('item_total_' + cartId);
                var totalPriceElement = document.getElementById('total_price');

                crtAmountElement.textContent = response.crtAmount;
                itemTotalElement.textContent = response.itemTotal;
                totalPriceElement.textContent = response.totalPrice;

                // เมื่อลบสินค้าแล้วตรวจสอบหากไม่มีสินค้าในตะกร้าแล้ว แสดงข้อความ
                var cartTable = document.querySelector('.table');
                if (cartTable.getElementsByTagName('tbody')[0].childElementCount === 1) {
                    var emptyCartMessage = document.createElement('p');
                    emptyCartMessage.classList.add('text-center', 'my-3');
                    emptyCartMessage.textContent = 'ไม่มีสินค้าในตะกร้าของคุณ';
                    cartTable.replaceWith(emptyCartMessage);
                }

                // ตรวจสอบถ้าถึงจำนวนสูงสุดแล้ว
                if (response.maxAmountReached) {
                    alert('ถึงจำนวนสูงสุดแล้ว');
                    // ทำอย่างอื่นตามที่ต้องการ
                }

                if (reloadPage) {
                    // โหลดหน้าใหม่
                    location.reload();
                }

            } else {
                alert('เกิดข้อผิดพลาดในการอัปเดตจำนวนสินค้า');
            }
        }
    };

    var data = "cartId=" + cartId + "&action=" + action;
    xhr.send(data);
}

</script>


    <script>
    
    function removeCartItem(cartId) {
    Swal.fire({
        title: 'ยืนยันการลบ',
        text: 'คุณแน่ใจหรือไม่ว่าต้องการลบสินค้านี้?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ใช่, ลบ!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "remove_cart_item.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // After successfully removing the item from the cart
                        window.location.reload(); // Reload the page
                    } else {
                        alert('เกิดข้อผิดพลาดในการลบสินค้า');
                    }
                }
            };

            var data = "cartId=" + cartId;
            xhr.send(data);
        }
    });
}



   

    function recalculateTotal() {
        var total = 0;
        var itemTotalElements = document.querySelectorAll("span[id^='item_total_']");

        itemTotalElements.forEach(function(itemTotalElement) {
            total += parseFloat(itemTotalElement.textContent);
        });

        var totalPriceElement = document.getElementById('total_price');
        totalPriceElement.textContent = total;
    }
    </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>