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

    <?php


    // Check if the member ID is provided in the query string
    if (isset($_SESSION['mmb_id'])) {
        $mmb_id = $_SESSION['mmb_id']; // Use the member ID from the session

        // Search for member data in the database
        $sql = "SELECT * FROM member WHERE mmb_id = '$mmb_id'";
        $result = $proj_connect->query($sql);



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $mmb_name = $row['mmb_name'];
            $mmb_surname = $row['mmb_surname'];
            $mmb_username = $row['mmb_username'];
            $mmb_pwd = $row['mmb_pwd'];
            $mmb_addr = $row['mmb_addr'];
            $mmb_phone = $row['mmb_phone'];
            $mmb_email = $row['mmb_email'];

            $mmb_show = $row['mmb_show'];
        } else {
            // If the member to edit is not found in the database
            echo "ไม่พบข้อมูลสมาชิกที่ต้องการแก้ไข";
            exit;
        }
        // Initialize an array to hold the orders
        $memberOrders = array();
    }

    // Check if the order ID is provided in the query string
    if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id']; // Use the order ID from the query string

        // Fetch the specific order details from the orders table
        $orderSql = "SELECT * FROM orders WHERE order_id = ?";
        $stmt = $proj_connect->prepare($orderSql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $orderResult = $stmt->get_result();

        if ($orderResult->num_rows > 0) {
            $orderDetails = $orderResult->fetch_assoc(); // Fetch order details
        } else {
            echo "ไม่พบข้อมูลคำสั่งซื้อ";
            exit;
        }

        // Fetch associated order items from the order_detail table
        $detailSql = "SELECT od.*, p.prd_name, p.prd_img FROM order_detail od INNER JOIN product p ON od.prd_id = p.prd_id WHERE od.order_id = ?";
        $detailStmt = $proj_connect->prepare($detailSql);
        $detailStmt->bind_param("i", $order_id);
        $detailStmt->execute();
        $detailResult = $detailStmt->get_result();


        $orderItems = [];
        if ($detailResult->num_rows > 0) {
            while ($row = $detailResult->fetch_assoc()) {
                $orderItems[] = $row; // Store order items
            }
        }

        $detailStmt->close();
    } else {
        echo "ไม่ระบุรหัสคำสั่งซื้อ";
        exit;
    }
    ?>


    <header>
        <!-- Navbar -->
        <?php include('mainweb_page/nav_bar.php'); ?>
        <!-- Navbar -->





    </header>

    <main>

        <div class="container pt-5">
            <!-- Display order details -->
            <article class="card mb-3">
                <header class="card-header"><a href="profile.php?tab=orders">กลับหน้ารายการคำสั่งซื้อ</a> </header>
                <div class="card-body">
                    <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($orderDetails['order_id'], 10, "0", STR_PAD_LEFT); ?>
                        <span class="badge bg-danger mb-0 float-end"><?php echo $orderDetails['status']; ?></span>
                    </h6>
                    <div class="row">
                        <!-- Display additional order details here -->
                    </div>

                    <!-- Display associated order items -->
                    <?php if (!empty($orderItems)) : ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>รูป</th>
                                        <th>ชื่อสินค้า</th>
                                        <th>จำนวน</th>
                                        <th>ราคา</th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderItems as $item) : ?>
                                        <tr>
                                            <td>
                                                <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $item['prd_img']; ?>" alt="Product Image" style="height: 50px;"> <!-- Display product image -->
                                                <?php echo $item['prd_name']; ?>
                                            </td>
                                            <td><?php echo $item['prd_name']; ?></td>
                                            <td><?php echo $item['crt_amount']; ?></td>
                                            <td>฿<?php echo number_format($item['item_totals'], 2); ?></td>
                                            <!-- Add more details as needed -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>ยอดสุทธิ</th>
                                        <td>฿<?php echo number_format($orderDetails['totalPrice'], 2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else : ?>
                        <p>No items found for this order.</p>
                    <?php endif; ?>
                </div>
            </article>
        </div>
    </main>

    <!-- footer -->

    <?php include('mainweb_page/footer.php'); ?>

    <!-- footer -->


    <!-- end_script -->

    <?php include('mainweb_page/end_script.php'); ?>
    <!-- end_script -->
    <!-- end_script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');

            if (tab) {
                let tabToShow = document.querySelector(`a[href="#${tab}"]`);
                if (tabToShow) {
                    new bootstrap.Tab(tabToShow).show(); // For Bootstrap 5
                }
            }
        });
    </script>


</body>

</html>