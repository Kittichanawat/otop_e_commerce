<?php
require('connect/connect.php');
session_start();

if (!isset($_SESSION['crt_success'])) {
    // Redirect or handle the case where order ID is not set
    header("Location: ./"); // Example redirection
    exit;
}

$mmb_id = $_SESSION['mmb_id'];

// ดึงรายการสินค้าในตะกร้า รวมถึงข้อมูลราคาปกติและราคาโปรโมชั่น
$sql = "SELECT cart.crt_id, cart.prd_id, product.prd_name, product.prd_img, cart.crt_amount, product.prd_price, product.price_promotion, product.prd_promotion 
FROM cart 
INNER JOIN product ON cart.prd_id = product.prd_id 
WHERE cart.mmb_id = ?";
$stmt = $proj_connect->prepare($sql);
$stmt->bind_param("i", $mmb_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = array();
$totalPrice = 0;


while ($row = $result->fetch_assoc()) {
    $crt_id = $row['crt_id'];
    $prd_id = $row['prd_id'];
    $prd_name = $row['prd_name'];
    $prd_img = $row['prd_img'];
    $crt_amount = $row['crt_amount'];
    $prd_price = ($row['prd_promotion'] == 1 && $row['price_promotion'] > 0) ? $row['price_promotion'] : $row['prd_price']; // ใช้ราคาโปรโมชั่นหากมี

    // คำนวณราคารวมของรายการ
    $itemTotal = $prd_price * $crt_amount;
    $totalPrice += $itemTotal;

    // เพิ่มข้อมูลสินค้าลงใน array และ session
    $cartItems[] = array(
        'crt_id' => $crt_id,
        'prd_id' => $prd_id,
        'prd_name' => $prd_name,
        'prd_img' => $prd_img,
        'crt_amount' => $crt_amount,
        'itemTotal' => $itemTotal,
    );
}

// สร้าง URL สำหรับ checkout
$checkoutURL = "checkout_copy.php?mmb_id=$mmb_id&totalPrice=$totalPrice";
foreach ($cartItems as $item) {
    $checkoutURL .= "&crt_id[]={$item['crt_id']}&prd_id[]={$item['prd_id']}&prd_name[]={$item['prd_name']}&crt_amount[]={$item['crt_amount']}&itemTotal[]={$item['itemTotal']}";
}

// สร้าง response ในรูปแบบ JSON
$response = array(
    'success' => true,
    'checkoutURL' => $checkoutURL,
);
$rows = array(); // เพิ่มบรรทัดนี้เพื่อกำหนดค่าเริ่มต้น
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
}

?>


<?php
// Assuming you have a connection to the database established


// Fetch data from the banking table
$banking_query = "SELECT * FROM banking ORDER BY order_column ASC";
$banking_result = $proj_connect->query($banking_query);

// Check if there are rows in the result
if ($banking_result->num_rows > 0) {
    $banks = $banking_result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle the case where no banks are found
    $banks = array();
}
?>

<?php



// Select data from the member table based on mmb_id
$member_query = "SELECT * FROM member WHERE mmb_id = $mmb_id";
$member_result = $proj_connect->query($member_query);

// Check if there are rows in the result
if ($member_result->num_rows > 0) {
    $member_data = $member_result->fetch_assoc();
    $mmb_name = $member_data['mmb_name'];
    $mmb_surname = $member_data['mmb_surname'];
    $mmb_phone = $member_data['mmb_phone'];
    $mmb_addr = $member_data['mmb_addr'];
    $mmb_email = $member_data['mmb_email'];
} else {
    // Handle the case where no member data is found
    $mmb_name = '';
    $mmb_phone = '';
    $mmb_addr = '';
    $mmb_email = '';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTOP จังหวัดเชียงใหม่</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo.png">
    <!-- Link Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;1,100;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="heroes.css">
    <link rel="stylesheet" href="jumbotrons.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    <!-- Bootstrap CSS -->


    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>




    <!-- เพิ่ม CSS ของ Navbar ที่คุณต้องการแก้ไข -->
    <style>
        body {
            margin-top: 20px;
            background-color: #f1f3f7;
        }

        .card {
            margin-bottom: 24px;
            -webkit-box-shadow: 0 2px 3px #e4e8f0;
            box-shadow: 0 2px 3px #e4e8f0;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #eff0f2;
            border-radius: 1rem;
        }

        .activity-checkout {
            list-style: none
        }

        .activity-checkout .checkout-icon {
            position: absolute;
            top: -4px;
            left: -24px
        }

        .activity-checkout .checkout-item {
            position: relative;
            padding-bottom: 24px;
            padding-left: 35px;
            border-left: 2px solid #f5f6f8
        }

        .activity-checkout .checkout-item:first-child {
            border-color: #3b76e1
        }

        .activity-checkout .checkout-item:first-child:after {
            background-color: #3b76e1
        }

        .activity-checkout .checkout-item:last-child {
            border-color: transparent
        }

        .activity-checkout .checkout-item.crypto-activity {
            margin-left: 50px
        }

        .activity-checkout .checkout-item .crypto-date {
            position: absolute;
            top: 3px;
            left: -65px
        }



        .avatar-xs {
            height: 1rem;
            width: 1rem
        }

        .avatar-sm {
            height: 2rem;
            width: 2rem
        }

        .avatar {
            height: 3rem;
            width: 3rem
        }

        .avatar-md {
            height: 4rem;
            width: 4rem
        }

        .avatar-lg {
            height: 5rem;
            width: 5rem
        }

        .avatar-xl {
            height: 6rem;
            width: 6rem
        }

        .avatar-title {
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background-color: #3b76e1;
            color: #fff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            font-weight: 500;
            height: 100%;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%
        }

        .avatar-group {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 8px
        }

        .avatar-group .avatar-group-item {
            margin-left: -8px;
            border: 2px solid #fff;
            border-radius: 50%;
            -webkit-transition: all .2s;
            transition: all .2s
        }

        .avatar-group .avatar-group-item:hover {
            position: relative;
            -webkit-transform: translateY(-2px);
            transform: translateY(-2px)
        }

        .card-radio {
            background-color: #fff;
            border: 2px solid #eff0f2;
            border-radius: .75rem;
            padding: .5rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block
        }

        .card-radio:hover {
            cursor: pointer
        }

        .card-radio-label {
            display: block
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px
        }

        .card-radio-input {
            display: inline-block;
            /* เปลี่ยน display เป็น inline-block */
            position: absolute;
            /* เพิ่ม position */
            opacity: 0;
            /* เพิ่ม opacity เป็น 0 */
            pointer-events: none;
            /* เพิ่ม pointer-events เป็น none */
        }

        .card-radio-input:checked+.card-radio {
            border-color: #3b76e1 !important
        }


        .font-size-16 {
            font-size: 16px !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        a {
            text-decoration: none !important;
        }


        .form-control {
            display: block;
            width: 100%;
            padding: 0.47rem 0.75rem;
            font-size: .875rem;
            font-weight: 400;
            line-height: 1.5;

            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #e2e5e8;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.75rem;
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        }

        .edit-btn {
            width: 35px;
            height: 35px;
            line-height: 40px;
            text-align: center;
            position: absolute;
            right: 25px;
            margin-top: -50px;
        }

        .ribbon {
            position: absolute;
            right: -26px;
            top: 20px;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 1px 22px;
            font-size: 13px;
            font-weight: 500
        }
    </style>


</head>
<script>
    // ฟังก์ชั่นในการดึงค่าพารามิเตอร์จาก URL
    function getUrlParameter(name) {
        name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // ตัวอย่างการใช้
    var mmb_id = getUrlParameter('mmb_id');
    var totalPrice = getUrlParameter('totalPrice');

    // แสดงผลใน Console เพื่อตรวจสอบว่าได้ค่าถูกต้องหรือไม่
    console.log('mmb_id:', mmb_id);
    console.log('totalPrice:', totalPrice);
</script>



<body>

    <form method="POST" id="yourFormId">
        <div class="container ">
            <nav class="navbar navbar-light bg-white border-0 shadow-sm rounded-3 mb-4">
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
            <div class="row">
                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body">
                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">ข้อมูลการสั่งซื้อ</h5>
                                            <p class="text-muted text-truncate mb-4">ที่อยู่ในการจัดส่ง</p>
                                            <div class="mb-3">

                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="mmb_id" value="<?php echo $mmb_id; ?>">
                                                                <label class="form-label" for="billing-name">ชื่อ</label>
                                                                <input type="text" class="form-control" id="mmb_name" name="mmb_name" placeholder="กรุณากรอกชื่อ" value="<?php echo $mmb_name; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="billing-name">นามสกุล</label>
                                                                <input type="text" class="form-control" id="mmb_surname" name="mmb_surname" placeholder="กรุณากรอกนามสกุล" value="<?php echo $mmb_surname; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="billing-email-address">อีเมล</label>
                                                                <input type="email" class="form-control" id="mmb_email" name="mmb_email" placeholder="กรุณากรอกอีเมล" value="<?php echo $mmb_email; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="billing-phone">เบอร์โทรศัพท์</label>
                                                                <input type="text" class="form-control" id="mmb_phone" name="mmb_phone" placeholder="กรุณากรอกเบอร์โทรศัพท์" value="<?php echo $mmb_phone; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="billing-address">ที่อยู่ในการจัดส่ง</label>
                                                        <textarea class="form-control" id="mmb_addr" name="mmb_addr" rows="3" placeholder="กรุณากรอกที่อยู่ในการจัดส่ง"><?php echo $mmb_addr; ?></textarea>
                                                    </div>


                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">ข้อมูลการชำระเงิน</h5>
                                            <p class="text-muted text-truncate mb-4"></p>
                                        </div>
                                        <div>
                                            <h5 class="font-size-14 mb-3">เลือกวิธีการชำระเงิน:</h5>
                                            <div class="row">

                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse" data-bs-target="#bankOption">
                                                        <label class="card-radio-label">

                                                            <input type="radio" name="pay_method" id="cash_on_delivery" value="จ่ายผ่านบัญชีธนาคาร" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center ">

                                                                <i class='bx bxs-bank d-block h2 mb-3'></i>
                                                                โอนเงินผ่านธนาคาร
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>



                                                <div class="col-lg-3 col-sm-6">
                                                    <div>
                                                        <label class="card-radio-label">

                                                            <input type="radio" name="pay_method" id="cash_on_delivery" value="เก็บเงินปลายทาง" class="card-radio-input">

                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <i class="bx bx-money d-block h2 mb-3"></i>
                                                                <span>เก็บเงินปลายทาง</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <div class="collapse" id="bankOption">
                                                        <div class="container">
                                                            <div class="card shadow-lg">
                                                                <div class="card-body">
                                                                    <p class="text-center h4">ขั้นตอนโอนเงินและแนบหลักฐาน</p>
                                                                    <p class="text-center text-danger d-block ">** คุณสามารถชำระเงิน และแนบหลักฐานการโอนเงิน หลังจากกดปุ่ม “ยืนยันการสั่งซื้อ” **</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col pb-5">
                                                                <span class='badge rounded bg-primary mb-3'>1</span> เลือกโอนเงินผ่านรายชื่อบัญชีธนาคารดังนี้<br>
                                                                <div class="row">
                                                                    <?php foreach ($banks as $bank) : ?>
                                                                        <div class="col-lg-6 col-sm-6 mb-3">
                                                                            <div class="card shadow-lg">
                                                                                <div class="card-body">
                                                                                    <label class="card-radio-label">
                                                                                        <!-- Adjust the input's value to send the bank's id -->
                                                                                       
                                                                                        <img src="startbootstrap-sb-admin-2-gh-pages/pages/banking/<?php echo $bank['bank_img']; ?>" alt="<?php echo $bank['bank_name']; ?>" class="img-fluid mb-2" width="40" height="40">
                                                                                        <?php echo $bank['bank_name']; ?><br>
                                                                                        ชื่อบัญชี:<?php echo $bank['acc_name']; ?><br>
                                                                                        เลขบัญชี:<?php echo $bank['bank_number']; ?><br>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    <?php endforeach; ?>
                                                                </div>



                                                                <span class='badge rounded bg-primary mb-3'>2</span> แนบหลักฐานการโอนเงิน ภายใน 24 ชั่วโมง<br>
                                                                <div class="row">

                                                                    <!-- Display bank options here dynamically -->

                                                                    <div class="card shadow-lg ">
                                                                        <div class="card-body">
                                                                            <p>
                                                                            <ul>
                                                                                <li>
                                                                                    <p>หลังจากทำการยืนยันการสั่งซื้อสินค้าแล้ว ให้ไปที่เมนู > “แจ้งชำระเงิน”
                                                                                        จะมีฟอร์มให้ใส่รายละเอียดการชำระเงิน สามารถกดแนบหลักฐานการโอนเงินได้</p>
                                                                                </li>

                                                                            </ul>
                                                                            </p>
                                                                        </div>



                                                                        <!-- Add more banks as needed -->
                                                                    </div>
                                                                </div>


                                                                <span class='badge rounded bg-primary'>3</span> สินค้าจะเริ่มเข้าสู่กระบวนการจัดส่งเมื่อทีมงานได้รับหลักฐานการชำระเงิน

                                                            </div>
                                                        </div>





                                                    </div>
                                                </div>

                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col">
                            <a href="./" class="btn btn-link text-muted">
                                <i class="mdi mdi-arrow-left me-1"></i> กลับหน้าหลัก </a>
                        </div> <!-- end col -->
                        <div class="col">
                            <div class="text-end mt-2 mt-sm-0">

                                <button type="submit" class="btn btn-primary"><i class="mdi mdi-cart-outline me-1"></i> ยืนยันการสั่งซื้อ</button>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </div>
                <div class="col-xl-4">
                    <div class="card checkout-order-summary ">
                        <div class="card-body">
                            <div class="p-3 bg-light mb-3">
                                <h5 class="font-size-16 mb-0">สรุปคำสั่งซื้อ </h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0" style="width: 110px;" scope="col"></th>
                                            <th class="border-top-0" scope="col"></th>
                                            <th class="border-top-0" scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cartItems as $key => $item) : ?>
                                            <tr>
                                                <input type="hidden" name="order[]" value="<?php echo $key + 1; ?>">
                                                <th scope="row"><img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $item['prd_img']; ?>" alt="product-img" title="product-img" class="avatar-lg rounded"></th>
                                                <td>
                                                    <h5><a href="#" class="text-dark"><?php echo $item['prd_name']; ?></a></h5>
                                                    <input type="hidden" name="prd_name[]" value="<?php echo $item['prd_name']; ?>">
                                                    <input type="hidden" name="prd_id[]" value="<?php echo $item['prd_id']; ?>">
                                                    <!-- <p class="text-muted mb-0">
                                                    <i class="bx bxs-star text-warning"></i>
                                                    <i class="bx bxs-star text-warning"></i>
                                                    <i class="bx bxs-star text-warning"></i>
                                                    <i class="bx bxs-star text-warning"></i>
                                                    <i class="bx bxs-star-half text-warning"></i>
                                                </p> -->
                                                    <p class="text-muted mb-0 mt-1">฿ <?php echo$prd_price; ?> x <?php echo $item['crt_amount']; ?></p>
                                                    <input type="hidden" name="crt_amount[]" value="<?php echo $item['crt_amount']; ?>">
                                                    <input type="hidden" name="item_totals[]" value="<?php echo $item['itemTotal']; ?>">
                                                    <input type="hidden" name="crt_id[]" value="<?php echo $item['crt_id']; ?>">
                                                </td>
                                                <td>฿ <?php echo $item['itemTotal']; ?></td>

                                            </tr>
                                        <?php endforeach; ?>


                                  


                                        <tr class="bg-light">
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">ยอดสุทธิ:</h5>
                                            </td>
                                            <td>
                                                ฿ <?php echo number_format($totalPrice, 2); ?>

                                                <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">

                                            </td>

                                        </tr>




                                    </tbody>
                                </table>


                                <!-- </div>
                            <div class="container mt-3">
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">
            <i class="mdi mdi-cart-outline me-1"></i> ยืนยันการสั่งซื้อ
        </button>
    </div>
</div> -->


                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>

    </form>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#yourFormId").validate({
                rules: {
                    mmb_name: {
                        required: true,
                    },
                    mmb_surname: {
                        required: true,
                    },
                    mmb_addr: {
                        required: true,
                    },
                    mmb_email: {
                        required: true,
                        email: true
                    },
                    mmb_phone: {
                        required: true,
                        digits: true,
                        maxlength: 20
                    },
                    pay_method: {
                        required: true,

                    }



                },
                messages: {
                    mmb_name: 'โปรดกรอกข้อมูล ชื่อ',
                    mmb_surname: 'โปรดกรอกข้อมูล นามสกุล',
                    mmb_email: {
                        required: 'โปรดกรอกข้อมูล Email',
                        email: 'โปรดกรอก Email ให้ถูกต้อง'
                    },
                    mmb_addr: {
                        required: 'โปรดกรอกข้อมูล ที่อยู่',

                    },
                    mmb_phone: {
                        required: 'โปรดกรอกข้อมูล เบอร์โทรศัพท์',
                        digits: 'โปรดกรอกตัวเลขเท่านั้น',
                        maxlength: 'โปรดกรอกตัวเลขไม่เกิน 20 ตัว',
                    },


                    pay_method: {
                        required: 'โปรดเลือกวิธีการชำระเงิน',

                    }

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
                }

            });

            // เพิ่มกฎสำหรับตรวจสอบรหัสผ่านที่แข็งแกร่ง
            $.validator.addMethod('strongPassword', function(value, element) {
                return this.optional(element) ||
                    value.length >= 6 &&
                    /\d/.test(value) &&
                    /[a-z]/i.test(value);
            }, 'รหัสผ่านควรมีอย่างน้อย 6 ตัว, ประกอบไปด้วยตัวเลข, ตัวอักษรตัวใหญ่ และตัวเล็ก');

            // เพิ่มกฎสำหรับตรวจสอบชื่อผู้ใช้ที่ประกอบด้วยอักษรอังกฤษและตัวเลขเท่านั้น
            $.validator.addMethod('alphanumeric', function(value, element) {
                return this.optional(element) || /^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]+$/.test(value);
            }, 'ชื่อผู้ใช้ควรประกอบด้วยอักษรอังกฤษและตัวเลข');
        });




        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("yourFormId").addEventListener("submit", function(event) {
                event.preventDefault(); // ป้องกันการส่งข้อมูลแบบปกติ
                var isValid = $("#yourFormId").valid();
                if (!isValid) {
                    // หากมีข้อมูลที่ไม่ถูกต้องหรือขาดหาย ไม่ทำการส่งข้อมูล
                    return;
                }
                // ดึงข้อมูลจากฟอร์ม
                var formData = new FormData(this);

                // ส่งข้อมูลไปยัง insert_orders.php โดยใช้ fetch API
                fetch("insert_orders.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(function(response) {
                        return response.json(); // แปลง response เป็น JSON
                    })
                    .then(function(data) {
                        // ตรวจสอบว่าการสั่งซื้อสำเร็จหรือไม่
                        if (data.success) {
                            // แจ้งเตือนสำเร็จ
                            Swal.fire({
                                icon: 'success',
                                title: 'สั่งซื้อสำเร็จ',
                                text: 'คำสั่งซื้อคุณสำเร็จ!!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // ส่งผู้ใช้ไปยังหน้า success_page.php
                                window.location.href = 'success_page.php';
                            });
                        } else {
                            // แจ้งเตือนเมื่อมีข้อผิดพลาด
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'มีบางอย่างผิดพลาดในการสั่งซื้อ'
                            });
                        }
                    })
                    .catch(function(error) {
                        console.error('เกิดข้อผิดพลาด:', error);
                        // แจ้งเตือนเมื่อมีข้อผิดพลาด
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: 'มีบางอย่างผิดพลาดในการสั่งซื้อ'
                        });
                    });
            });
        });
    </script>

    <!-- Add this script block after including SweetAlert and before the closing </body> tag -->
    <script>

    </script>
    <script>
        // Handle radio button change event
        document.addEventListener('change', function(event) {
            const bankOption = document.getElementById('bankOption');

            // Check if the clicked radio button is inside the tab navigation
            const isInsideBankOption = bankOption.contains(event.target);

            if (event.target.name === 'pay-method' && event.target.value === 'bank' && !isInsideBankOption) {
                // If Bank radio button is selected and not inside the tab navigation, show tab navigation
                bankOption.classList.add('show');
            } else if (!isInsideBankOption) {
                // If other radio buttons are selected and not inside the tab navigation, hide tab navigation
                bankOption.classList.remove('show');

                // Unselect radio buttons inside the tab navigation
                const radioButtonsInsideBankOption = bankOption.querySelectorAll('input[type="radio"]');
                radioButtonsInsideBankOption.forEach(radioButton => {
                    radioButton.checked = false;
                });
            }
        });
    </script>




    <!-- ในส่วนของ JavaScript -->
    <!-- <script>
    // Handle radio button change event
    document.addEventListener('change', function (event) {
        const bankOptions = document.getElementById('bankOption');

        if (event.target.name === 'pay-methodoption1') {
            // If 'Bank' option is selected, show bank options
            bankOptions.classList.add('show');
        } else {
            // If any other option is selected, hide bank options
            bankOptions.classList.remove('show');
        }

        // Handle the selected bank information
        if (event.target.name === 'bank-option' && event.target.checked) {
            const bankInfo = event.target.getAttribute('data-bank');
            alert(`You selected ${bankInfo}`);
            // You can customize this part to show or handle the selected bank information
        }
    });
</script> -->



    <!-- Add this script block after including SweetAlert and before the closing </body> tag -->


    <?php include('mainweb_page/end_script.php'); ?>
</body>

</html>