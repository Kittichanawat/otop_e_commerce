<?php
session_start();
require('connect/connect.php'); // Ensure you have a database connection file

// Check if the order ID is set in the session
if (!isset($_SESSION['order_id'])) {
    // Redirect or handle the case where order ID is not set
    header("Location: ./"); // Example redirection
    exit;
}

$order_id = $_SESSION['order_id'];

// Fetch order details
$order_query = "SELECT * FROM orders WHERE order_id = $order_id";
$order_result = $proj_connect->query($order_query);
$order_details = $order_result->fetch_assoc();

// Fetch member's address from ship_info table
$ship_info_query = "SELECT * FROM ship_info WHERE order_id = $order_id";
$ship_info_result = $proj_connect->query($ship_info_query);
$ship_info = $ship_info_result->fetch_assoc();

// Fetch order items
$order_items_query = "SELECT od.*, p.prd_name, p.prd_img FROM order_detail od JOIN product p ON od.prd_id = p.prd_id WHERE od.order_id = $order_id";
$order_items_result = $proj_connect->query($order_items_query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('mainweb_page/head.php');
?>

<body>
    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <!-- Card content -->

                    <div class="invoice p-5">
                        <div class="mb-4">
                            <a href="./" class="navbar-brand"><img src="assets/img/logo.png" alt="" style="width: 50px; margin-right: 15px;">OTOP เชียงราย</a></a>
                        </div>
                        <h5>สั่งซื้อสำเร็จ!</h5>
                        <span class="font-weight-bold d-block mt-4">
                            ชื่อผู้สั่งซื้อ: <?php echo htmlspecialchars($ship_info['mmb_name']) . " " . htmlspecialchars($ship_info['mmb_surname']); ?>
                        </span>


                        <!-- Display dynamic order details -->
                        <div class="payment border-top mt-3 mb-3 border-bottom table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="py-2"><span class="d-block text-muted">วันเวลาที่สั่งซื้อ</span><span><?php echo $order_details['created_at']; ?></span></div>
                                        </td>
                                        <td>
                                            <div class="py-2"><span class="d-block text-muted">เลขที่ใบสั่งซื้อ</span><span><?php echo $order_details['order_id']; ?></span></div>
                                        </td>
                                        <td>
                                            <div class="py-2"><span class="d-block text-muted">วิธีการชำระเงิน</span><span><?php echo $order_details['pay_method']; ?></span></div>
                                        </td>
                                        <td>
                                            <div class="py-2"><span class="d-block text-muted overflow-hidden">ที่อยู่ในการจัดส่ง</span><span><?php echo htmlspecialchars($ship_info['mmb_addr']) . " " . htmlspecialchars($ship_info['mmb_surname']); ?></span></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="product border-bottom table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <?php while ($item = $order_items_result->fetch_assoc()) : ?>
                                        <tr>
                                            <td width="20%"><img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $item['prd_img']; ?>" width="90"></td>
                                            <td width="60%">
                                                <span class="font-weight-bold"><?php echo $item['prd_name']; ?></span>
                                                <div class="product-qty"><span class="d-block">จำนวน:<?php echo $item['crt_amount']; ?></span></div>
                                            </td>
                                            <td width="20%">
                                                <div class="text-right"><span class="font-weight-bold">฿<?php echo $item['item_totals']; ?></span></div>
                                            </td>
                                        </tr>

                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row d-flex justify-content-end">

                            <div class="col-md-5">

                                <table class="table table-borderless">

                                    <tbody class="totals">

                                        <tr>



                                        <tr class="border-top border-bottom">
                                            <td>
                                                <div class="text-left">

                                                    <span class="font-weight-bold">ยอดสุทธิ</span>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <span class="font-weight-bold"><?php echo $order_details['totalPrice']; ?></span>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>

                            </div>



                        </div>
                        <p>สถานะ: <?php echo $order_details['status']; ?></p>
                        <?php if ($order_details['pay_method'] == 'จ่ายผ่านบัญชีธนาคาร') : ?>
                            <p class="text-danger">** กรุณาแจ้งการชำระเงินภายใน 24 ถ้าไมทำการแจ้งชำระเงินระบบจะยกเลิกออเดอร์อัตโนมัติ ** </p>
                        <?php elseif ($order_details['pay_method'] == 'เก็บเงินปลายทาง') : ?>
                            <p>เราจะทำการจัดส่งสินค้าให้เร็วที่สุด!</p>
                        <?php endif; ?>
                        <p class="font-weight-bold mb-0">ขอบคุณที่สั่งซื้อกับเรา!</p>
                        <span>OTOP เชียงราย</span>


                        <!-- Other sections -->
                        <!-- ... -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="actions text-center mb-5">
        <a href="index.php" class="btn btn-primary">เลือกซื้อสินค้าต่อ</a>
        <?php if ($order_details['status'] == 'รอการชำระเงิน') : ?>
            <a href="pay.php" class="btn btn-secondary">ไปหน้าแจ้งชำระเงิน</a>
        <?php endif; ?>
    </div>

    <?php
    // ตรวจสอบว่า session ถูกเริ่มหรือไม่
    if (session_status() == PHP_SESSION_ACTIVE) {
        unset($_SESSION['order_id']);
    }
    ?>

    <?php include('mainweb_page/end_script.php');
    ?>
</body>

</html>