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

        // Prepare the SQL statement to select orders for the logged-in member
        $orderSql = "SELECT * FROM orders WHERE mmb_id = ? ORDER BY created_at DESC";
        $stmt = $proj_connect->prepare($orderSql);
        $stmt->bind_param("i", $mmb_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if any orders are found
        $cancelledOrders = [];
        $waitPaying = [];
        $payChecking = [];
        $waitShipping = [];
        $Shipping = [];
        if ($result->num_rows > 0) {
            // Fetch all orders and categorize them
            while ($row = $result->fetch_assoc()) {
                $memberOrders[] = $row;
                // Use the correct comparison for status
                if ($row['status'] == 'ยกเลิก') {
                    $cancelledOrders[] = $row;
                } elseif ($row['status'] == 'รอการชำระเงิน') {
                    $waitPaying[] = $row;
                } elseif ($row['status'] == 'รอตรวจสอบการชำระเงิน') {
                    $payChecking[] = $row;
                }elseif ($row['status'] == 'รอดำเนินการจัดส่ง') {
                    $waitShipping[] = $row;
                }elseif ($row['status'] == 'จัดส่งสินค้าแล้ว') {
                    $Shipping[] = $row;
                }
            }
        } else {
            // No orders found for the member
            echo "";
            // Optionally, handle the case where no orders are found
        }

        $stmt->close();
    } else {
        // If the member ID is not provided in the query string
        echo "ไม่ระบุรหัสสมาชิกที่ต้องการแก้ไข";
        exit;
    }


    ?>

    <header>
        <!-- Navbar -->
        <?php include('mainweb_page/nav_bar.php'); ?>
        <!-- Navbar -->





    </header>

    <main>
        <div class="container">


            <div class="row gutters-sm">
                <div class="col-md-4 d-none d-md-block">
                    <div class="card shadow">
                        <div class="card-body">
                            <ul class="nav flex-column nav-pills nav-gap-y-1">
                                <li class="nav-item">
                                    <a href="#profile" data-bs-toggle="pill" class="nav-link has-icon nav-link-faded active">
                                        <i class="fa-solid fa-user"></i> ข้อมูลส่วนตัว
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#account" data-bs-toggle="pill" class="nav-link has-icon nav-link-faded">
                                        <i class="fa-solid fa-gear"></i> Account Settings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#security" data-bs-toggle="pill" class="nav-link has-icon nav-link-faded">
                                        <i class="fa-solid fa-lock"></i> เปลี่ยนรหัสผ่าน
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#notification" data-bs-toggle="pill" class="nav-item nav-link has-icon nav-link-faded">
                                        <i class="fa-solid fa-bell"></i> Notification
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#billing" data-bs-toggle="pill" class="nav-item nav-link has-icon nav-link-faded">
                                        <i class="fa-solid fa-credit-card"></i> Billing
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#orders" data-bs-toggle="pill" class="nav-link has-icon nav-link-faded">
                                        <i class="fa-solid fa-clipboard"></i> รายการคำสั่งซื้อ
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header border-bottom mb-3 d-flex d-md-none">
                            <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                                <li class="nav-item">
                                    <a href="#profile" data-bs-toggle="pill" class="nav-link has-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#account" data-bs-toggle="pill" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                        </svg> </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#security" data-bs-toggle="pill" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                        </svg></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#notification" data-bs-toggle="pill" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#billing" data-bs-toggle="pill" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg></a>
                                </li>
                                <li class="nav-item">
                                    <a href="#orders" data-bs-toggle="pill" class="nav-link has-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
                                            <path d="M1 1h22l-2.01 13.65A1 1 0 0 1 20 15H4a1 1 0 0 1-.99-.85L1 1z"></path>
                                            <line x1="8" y1="15" x2="16" y2="15"></line>
                                        </svg></a>
                                </li>
                            </ul>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="passwordModalLabel">ยืนยันการเปลี่ยนแปลง</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="updateProfileForm" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">รหัสผ่าน</label>
                                                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                            <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body tab-content">
                            <div class="tab-pane active" id="profile">
                                <h6>ข้อมูลส่วนตัว</h6>
                                <hr>
                                <form method="POST" id="profileUpdateForm">
                                    <div class="mb-3">
                                        <label for="fullName" class="form-label">ชื่อจริง</label>
                                        <input type="text" class="form-control" name="mmb_name" id="mmb_name" aria-describedby="fullNameHelp" placeholder="กรุณากรอกชื่อ" value="<?php echo $mmb_name; ?>">

                                    </div>
                                    <div class="mb-3">
                                        <label for="fullName" class="form-label">นามสกุล</label>
                                        <input type="text" class="form-control" name="mmb_surname" id="mmb_surname" aria-describedby="fullNameHelp" placeholder="กรุณากรอกชื่อนามสกุล" value="<?php echo $mmb_surname; ?>">

                                    </div>

                                    <div class="mb-3">
                                        <label for="bio" class="form-label">ที่อยู่</label>
                                        <textarea class="form-control" name="mmb_addr" id="mmb_addr" placeholder="กรุณากรอกที่อยู่" rows="3"><?php echo $mmb_addr; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="url" class="form-label">เบอร์โทร</label>
                                        <input type="text" class="form-control" name="mmb_phone" id="mmb_phone" placeholder="กรุณากรอกเบอร์โทร" value="<?php echo $mmb_phone; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="location" class="form-label">อีเมล</label>
                                        <input type="email" class="form-control" name="mmb_email" id="mmb_email" placeholder="กรุณากรอกอีเมล" value="<?php echo $mmb_email; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" id="updateProfileButton" class="form-label">กรุณายืนยันรหัสเพื่อแก้ไขข้อมูล</label>
                                        <input type="password" class="form-control" name="mmb_pwd" id="mmb_pwd" placeholder="กรุณากรอกรหัสยืนยัน">
                                    </div>
                                    <!-- <div class="form-text mb-3 text-muted">All of the fields on this page are optional and can
                                        be deleted at any time, and by filling them out, you're giving us consent to share
                                        this data wherever your user profile appears.</div> -->
                                    <button type="submit" class="btn btn-primary">
                                        ยืนยันการแก้ไขข้อมูล
                                    </button>
                                    <button type="reset" class="btn btn-light">รีเซ็ทการเปลี่ยนแปลง</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="account">
                                <h6>ACCOUNT SETTINGS</h6>
                                <hr>
                                <form>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter your username" value="kennethvaldez">
                                        <div id="usernameHelp" class="form-text">After changing your username, your old
                                            username becomes available for anyone else to claim.</div>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label class="d-block text-danger">Delete Account</label>
                                        <p class="text-muted font-size-sm">Once you delete your account, there is no going
                                            back. Please be certain.</p>
                                    </div>
                                    <button class="btn btn-danger" type="button">Delete Account</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="security">
                                <h6>เปลี่ยนรหัสผ่าน</h6>
                                <hr>
                                <form method id="passwordchange">
                                    <div class="mb-3">

                                        <input type="password" class="form-control mt-3" name="old_password" placeholder="กรอกรหัสผ่านเก่า">
                                        <input type="password" class="form-control  mt-3" name="new_password" placeholder="กรอกรหัสผ่านใหม่">
                                        <input type="password" class="form-control   mt-3 " name="confirm_password" placeholder="กรอกยืนยันรหัสผ่านใหม่">


                                    </div>

                                    <hr>

                                    <div class="mb-3">

                                        <button class="btn btn-primary" type="submit">ยืนยันการเปลี่ยนรหัสผ่าน</button>

                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="notification">
                                <h6>NOTIFICATION SETTINGS</h6>
                                <hr>
                                <form>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="emailNotifications">
                                        <label class="form-check-label" for="emailNotifications">Receive email notifications</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="pushNotifications">
                                        <label class="form-check-label" for="pushNotifications">Receive push notifications</label>
                                    </div>
                                    <button type="button" class="btn btn-primary">Update Notification Settings</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="billing">
                                <h6>BILLING SETTINGS</h6>
                                <hr>
                                <form>
                                    <div class="mb-3">
                                        <label for="creditCard" class="form-label">Credit Card</label>
                                        <input type="text" class="form-control" id="creditCard" placeholder="Enter your credit card number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="billingAddress" class="form-label">Billing Address</label>
                                        <input type="text" class="form-control" id="billingAddress" placeholder="Enter your billing address">
                                    </div>
                                    <button type="button" class="btn btn-primary">Update Billing Settings</button>
                                </form>
                            </div>
                            <div class="card-body tab-content">
                                <!-- ... (existing code) ... -->
                                <!-- New Section: Order Details -->
                                <div class="tab-pane" id="orders">
                                    <h6>รายการคำสั่งซื้อ</h6>
                                    <hr>
                                    <!-- Order Status Tabs -->
                                    <ul class="nav nav-tabs mb-3">
                                        <li class="nav-item">
                                            <a href="#allOrders" data-bs-toggle="pill" class="nav-link active">ทั้งหมด</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#pendingPayment" data-bs-toggle="pill" class="nav-link">รอการชำระเงิน</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#payChecking" data-bs-toggle="pill" class="nav-link">รอตรวจสอบชำระเงิน</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#preparing" data-bs-toggle="pill" class="nav-link">รอดำเนินการจัดส่ง</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#shipping" data-bs-toggle="pill" class="nav-link"><i class="fa-solid fa-truck-fast"></i> จัดส่งสินค้าแล้ว</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="#cancelled" data-bs-toggle="pill" class="nav-link">ยกเลิก</a>
                                        </li>
                                    </ul>

                                    <!-- Order Status Content -->
                                    <div class="tab-content">
                                        <!-- All Orders -->
                                        <div class="tab-pane active" id="allOrders">
                                            <!-- Display all orders here -->

                                            <div class="container">
                                                <?php if (count($memberOrders) > 0) : ?>
                                                    <?php foreach ($memberOrders as $order) : ?>
                                                        <article class="card mb-3">
                                                            <?php
                                                            // Assuming you have the order ID
                                                            $order_id = $order['order_id'];
                                                            // Fetch the payment notification for this order
                                                            $payNotifSql = "SELECT * FROM payment_notifications WHERE order_id = '$order_id'";
                                                            $payNotifResult = $proj_connect->query($payNotifSql);
                                                            $payNotif = $payNotifResult->fetch_assoc();
                                                            ?>
                                                            <header class="card-header d-flex justify-content-between align-items-center">
                                                                รายการคำสั่งซื้อ
                                                                <p class="mb-0 text-end"> <a href="order_detail.php?order_id=<?php echo $order['order_id']; ?>&tab=orders">ดูรายละเอียด</a>
                                                                </p>
                                                            </header>

                                                            <div class="card-body">
                                                                <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($order['order_id'], 10, "0", STR_PAD_LEFT); ?></h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> วัน-เวลาที่สั่งซื้อ: <br> <?php echo ($order['created_at']); ?></div>

                                                                        <div class="col"> วิธีการชำระเงิน: <br> <?php echo ($order['pay_method']); ?> </div>
                                                                        <div class="col"> สถานะคำสั่งซื้อ: <br> <span class="badge bg-danger"><?php echo ($order['status']); ?></span> </div>
                                                                        <div class="col"> ยอดรวม: <br> ฿<?php echo number_format($order['totalPrice'], 2, '.', ','); ?></div>
                                                                        <?php if ($payNotif && $order['status'] == 'รอตรวจสอบการชำระเงิน') : ?>
                                                                        <div class="col">
                                                                            ไฟล์การชำระเงิน: <br>
                                                                         
                                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#payImgModalall<?php echo $order_id; ?>">
                                                                                    <i class="fas fa-paperclip"></i>
                                                                                </a>
                                                                          
                                                                        </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </article>

                                                                <hr>
                                                                <?php if ($order['status'] == 'รอการชำระเงิน') : ?>
                                                                    <a href="pay.php" class="btn btn-secondary">แนบหลักฐานการโอนเงิน</a>
                                                                    <a href="javascript:void(0);" class="btn btn-danger cancelOrderBtn " data-order-id="<?php echo $order['order_id']; ?>">ยกเลิกคำสั่งซื้อ</a>
                                                                <?php endif; ?>
                                                                <hr>

                                                            </div>
                                                            <div class="modal fade" id="payImgModalall<?php echo $order_id; ?>" tabindex="-1" aria-labelledby="payImgModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="payImgModalLabel">หลักฐานการชำระเงิน</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <img src="<?php echo $payNotif['pay_img']; ?>" class="img-fluid" alt="Payment Image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="container">
                                                        <p class="text-center text-muted">ไม่มีรายการคำสั่งซื้อ</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <!-- Add logic to fetch and display orders -->
                                        </div>


                                        <div class="tab-pane " id="cancelled">
                                            <!-- Display cancelled orders here -->
                                            <div class="container">
                                                <?php if (count($cancelledOrders) > 0) : ?>
                                                    <?php foreach ($cancelledOrders as $order) : ?>
                                                        <article class="card mb-3">
                                                            <header class="card-header d-flex justify-content-between align-items-center">
                                                                รายการคำสั่งซื้อที่ยกเลิก
                                                                <p class="mb-0 text-end">
                                                                    <a href="order_detail.php?order_id=<?php echo $order['order_id']; ?>&tab=orders">ดูรายละเอียด</a>
                                                                </p>
                                                            </header>

                                                            <div class="card-body">
                                                                <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($order['order_id'], 10, "0", STR_PAD_LEFT); ?></h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> วัน-เวลาที่สั่งซื้อ: <br> <?php echo $order['created_at']; ?></div>
                                                                        <div class="col"> วิธีการชำระเงิน: <br> <?php echo $order['pay_method']; ?> </div>
                                                                        <div class="col"> สถานะคำสั่งซื้อ: <br> <span class="badge bg-danger"><?php echo $order['status']; ?></span> </div>
                                                                        <div class="col"> ยอดรวม: <br> ฿<?php echo number_format($order['totalPrice'], 2, '.', ','); ?></div>
                                                                    </div>
                                                                </article>

                                                                <hr>
                                                            </div>
                                                        </article>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="container">
                                                        <p class="text-center text-muted">ไม่มีรายการคำสั่งซื้อที่ยกเลิก</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>




                                        <div class="tab-pane " id="pendingPayment">
                                            <!-- Display cancelled orders here -->
                                            <div class="container">
                                                <?php if (count($waitPaying) > 0) : ?>
                                                    <?php foreach ($waitPaying as $order) : ?>

                                                        <article class="card mb-3">

                                                            <header class="card-header d-flex justify-content-between align-items-center">
                                                                รายการคำสั่งซื้อที่รอการชำระเงิน
                                                                <p class="mb-0 text-end">
                                                                    <a href="order_detail.php?order_id=<?php echo $order['order_id']; ?>&tab=orders">ดูรายละเอียด</a>
                                                                </p>
                                                            </header>

                                                            <div class="card-body">
                                                                <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($order['order_id'], 10, "0", STR_PAD_LEFT); ?></h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> วัน-เวลาที่สั่งซื้อ: <br> <?php echo $order['created_at']; ?></div>
                                                                        <div class="col"> วิธีการชำระเงิน: <br> <?php echo $order['pay_method']; ?> </div>
                                                                        <div class="col"> สถานะคำสั่งซื้อ: <br> <span class="badge bg-danger"><?php echo $order['status']; ?></span> </div>
                                                                        <div class="col"> ยอดรวม: <br> ฿<?php echo number_format($order['totalPrice'], 2, '.', ','); ?></div>

                                                                    </div>
                                                                </article>

                                                                <hr>

                                                                <hr>
                                                            </div>
                                                        </article>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="container">
                                                        <p class="text-center text-muted">ไม่มีรายการคำสั่งซื้อที่รอการชำระเงิน</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="tab-pane " id="payChecking">
                                            <!-- Display cancelled orders here -->
                                            <div class="container">
                                                <?php if (count($payChecking) > 0) : ?>
                                                    <?php foreach ($payChecking as $order) : ?>
                                                        <article class="card mb-3">
                                                            <?php
                                                            // Assuming you have the order ID
                                                            $order_id = $order['order_id'];
                                                            // Fetch the payment notification for this order
                                                            $payNotifSql = "SELECT * FROM payment_notifications WHERE order_id = '$order_id'";
                                                            $payNotifResult = $proj_connect->query($payNotifSql);
                                                            $payNotif = $payNotifResult->fetch_assoc();
                                                            ?>
                                                            <header class="card-header d-flex justify-content-between align-items-center">
                                                                รายการคำสั่งซื้อที่รอตรวจสอบการชำระเงิน
                                                                <p class="mb-0 text-end">
                                                                    <a href="order_detail.php?order_id=<?php echo $order['order_id']; ?>&tab=orders">ดูรายละเอียด</a>
                                                                </p>
                                                            </header>

                                                            <div class="card-body">
                                                                <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($order['order_id'], 10, "0", STR_PAD_LEFT); ?></h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> วัน-เวลาที่สั่งซื้อ: <br> <?php echo $order['created_at']; ?></div>
                                                                        <div class="col"> วิธีการชำระเงิน: <br> <?php echo $order['pay_method']; ?> </div>
                                                                        <div class="col"> สถานะคำสั่งซื้อ: <br> <span class="badge bg-danger"><?php echo $order['status']; ?></span> </div>
                                                                        <div class="col"> ยอดรวม: <br> ฿<?php echo number_format($order['totalPrice'], 2, '.', ','); ?></div>
                                                                        <div class="col"> ไฟล์การชำระเงิน: <br> <?php if ($payNotif) : ?>
                                                                                <a href="#" data-bs-toggle="modal" data-bs-target="#payImgModal<?php echo $order_id; ?>">
                                                                                    <i class="fas fa-paperclip"></i>
                                                                                </a>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </article>

                                                                <hr>
                                                                <?php if ($order['status'] == 'รอการชำระเงิน') : ?>
                                                                    <a href="pay.php" class="btn btn-secondary">แนบหลักฐานการโอนเงิน</a>
                                                                    <a href="javascript:void(0);" class="btn btn-danger cancelOrderBtn " data-order-id="<?php echo $order['order_id']; ?>">ยกเลิกคำสั่งซื้อ</a>
                                                                <?php endif; ?>
                                                                <hr>
                                                            </div>
                                                            <div class="modal fade" id="payImgModal<?php echo $order_id; ?>" tabindex="-1" aria-labelledby="payImgModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="payImgModalLabel">หลักฐานการชำระเงิน</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <img src="<?php echo $payNotif['pay_img']; ?>" class="img-fluid" alt="Payment Image">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="container">
                                                        <p class="text-center text-muted">ไม่มีรายการคำสั่งซื้อที่รอการชำระเงิน</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <!-- Add tab panes for other order statuses -->
                                        <div class="tab-pane " id="preparing">
                                            <!-- Display cancelled orders here -->
                                            <div class="container">
                                                <?php if (count($waitShipping) > 0) : ?>
                                                    <?php foreach ($waitShipping as $order) : ?>

                                                        <article class="card mb-3">

                                                            <header class="card-header d-flex justify-content-between align-items-center">
                                                                รายการคำสั่งซื้อที่รอการจัดส่ง
                                                                <p class="mb-0 text-end">
                                                                    <a href="order_detail.php?order_id=<?php echo $order['order_id']; ?>&tab=orders">ดูรายละเอียด</a>
                                                                </p>
                                                            </header>

                                                            <div class="card-body">
                                                                <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($order['order_id'], 10, "0", STR_PAD_LEFT); ?></h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> วัน-เวลาที่สั่งซื้อ: <br> <?php echo $order['created_at']; ?></div>
                                                                        <div class="col"> วิธีการชำระเงิน: <br> <?php echo $order['pay_method']; ?> </div>
                                                                        <div class="col"> สถานะคำสั่งซื้อ: <br> <span class="badge bg-danger"><?php echo $order['status']; ?></span> </div>
                                                                        <div class="col"> ยอดรวม: <br> ฿<?php echo number_format($order['totalPrice'], 2, '.', ','); ?></div>

                                                                    </div>
                                                                </article>

                                                                <hr>

                                                                <hr>
                                                            </div>
                                                        </article>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="container">
                                                        <p class="text-center text-muted">ไม่มีรายการคำสั่งซื้อที่รอการจัดส่ง</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane " id="shipping">
                                            <!-- Display cancelled orders here -->
                                            <div class="container">
                                                <?php if (count($Shipping) > 0) : ?>
                                                    <?php foreach (    $Shipping as $order) : ?>

                                                        <article class="card mb-3">

                                                            <header class="card-header d-flex justify-content-between align-items-center">
                                                                รายการคำสั่งซื้อที่จัดส่งแล้ว
                                                                <p class="mb-0 text-end">
                                                                    <a href="order_detail.php?order_id=<?php echo $order['order_id']; ?>&tab=orders">ดูรายละเอียด</a>
                                                                </p>
                                                            </header>

                                                            <div class="card-body">
                                                                <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($order['order_id'], 10, "0", STR_PAD_LEFT); ?></h6>
                                                                <article class="card">
                                                                    <div class="card-body row">
                                                                        <div class="col"> วัน-เวลาที่สั่งซื้อ: <br> <?php echo $order['created_at']; ?></div>
                                                                        <div class="col"> วิธีการชำระเงิน: <br> <?php echo $order['pay_method']; ?> </div>
                                                                        <div class="col"> สถานะคำสั่งซื้อ: <br> <span class="badge bg-danger"><?php echo $order['status']; ?></span> </div>
                                                                        <div class="col"> ยอดรวม: <br> ฿<?php echo number_format($order['totalPrice'], 2, '.', ','); ?></div>

                                                                    </div>
                                                                </article>

                                                                <hr>

                                                                <hr>
                                                            </div>
                                                        </article>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <div class="container">
                                                        <p class="text-center text-muted">ไม่มีรายการคำสั่งซื้อที่จัดส่งแล้ว</p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </main>
    <!-- Modal -->

    <!-- footer -->

    <?php include('mainweb_page/footer.php'); ?>

    <!-- footer -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize form validation using jQuery Validate
            $("#profileUpdateForm").validate({
                rules: {
                    mmb_name: {
                        required: true
                    },
                    mmb_surname: {
                        required: true
                    },
                    mmb_addr: {
                        required: true
                    },
                    mmb_email: {
                        required: true,
                        email: true
                    },
                    mmb_phone: {
                        required: true
                    },
                    mmb_pwd: {
                        required: true
                    }
                },
                messages: {
                    // Custom messages for validation errors
                    mmb_name: 'กรุณากรอกชื่อ',
                    mmb_surname: 'กรุณากรอกนามสกุล',
                    mmb_email: {
                        required: 'กรุณากรอกอีเมล',
                        email: 'Please enter a valid email address'
                    },
                    mmb_addr: 'กรุณากรอกที่อยู่',
                    mmb_phone: {
                        required: 'กรุณากรอกเบอร์โทรศัพท์'
                    },
                    mmb_pwd: 'กรุณากรอกรหัสผ่าน'
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    // This function is called when the form is valid
                    var formData = new FormData(form);

                    // Send the form data to updateprofile.php using Fetch API
                    fetch("updateprofile.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Profile Updated Successfully',
                                    text: 'Your profile has been updated.'
                                }).then(() => {

                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to Update Profile',
                                    text: data.message || 'An error occurred while updating your profile.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred',
                                text: 'Unable to update profile.'
                            });
                        });
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize form validation using jQuery Validate
            $("#passwordchange").validate({
                rules: {
                    old_password: {
                        required: true
                    },
                    new_password: {
                        required: true
                    },
                    confirm_password: {
                        required: true
                    },

                },
                messages: {
                    // Custom messages for validation errors
                    old_password: 'กรุณากรอกรหัสผ่านเก่า',

                    confirm_password: 'กรุณากรอกยืนยันรหัสผ่านใหม่',


                    new_password: 'กรุณากรอกรหัสผ่านใหม่',
                },
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass('select2')) {
                        error.insertAfter(element.next('span'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    // This function is called when the form is valid
                    var formData = new FormData(form);

                    // Send the form data to updateprofile.php using Fetch API
                    fetch("passwordprocess.php", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Display success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Profile Updated Successfully',
                                    text: 'Your profile has been updated.'
                                }).then((result) => {
                                    // Check if the user clicked 'OK'
                                    if (result.isConfirmed) {
                                        // Reset the form
                                        $("#passwordchange").trigger("reset");
                                    }
                                });
                            } else {
                                // Display error message
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed to Update Profile',
                                    text: data.message || 'An error occurred while updating your profile.'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred',
                                text: 'Unable to update profile.'
                            });
                        });
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.cancelOrderBtn').click(function() {
                var orderId = $(this).data('order-id');
                Swal.fire({
                    title: 'ยืนยันการยกเลิกคำสั่งซื้อ?',
                    text: "คุณไม่สามารถกู้คืนการกระทำนี้ได้!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, ยกเลิกมัน!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'cancel_order.php', // สร้างไฟล์ PHP นี้สำหรับการยกเลิกคำสั่งซื้อ
                            type: 'POST',
                            data: {
                                order_id: orderId
                            },
                            success: function(response) {
                                // ตอบกลับจาก server ถ้ายกเลิกสำเร็จ
                                Swal.fire(
                                    'ยกเลิก!',
                                    'คำสั่งซื้อของคุณถูกยกเลิกแล้ว.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        // Assume each order row has an ID like 'order-row-XX'
                                        $("#order-row-" + orderId).hide(); // Hides the row with the cancelled order
                                    }
                                });
                            }
                        });
                    }
                })
            });
        });
    </script>

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


    <?php include('mainweb_page/end_script.php'); ?>
    <!-- end_script -->


</body>

</html>