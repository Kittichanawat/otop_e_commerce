<?php
require('connect/connect.php');

session_start();

if (isset($_SESSION['mmb_id'])) {
    $mmb_id = $_SESSION['mmb_id'];

    // ดึงข้อมูลสินค้าในตะกร้าของผู้ใช้ปัจจุบัน
    $sql = "SELECT cart.crt_id, product.prd_id, product.prd_name, product.prd_price, product.prd_img, cart.crt_amount 
            FROM cart 
            INNER JOIN product ON cart.prd_id = product.prd_id 
            WHERE cart.mmb_id = $mmb_id";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        // ดึงข้อมูลจากรายการสินค้าในตะกร้า
        $cartData = [];
        $totalPrice = 0;

        while ($row = $result->fetch_assoc()) {
            $cartData[] = [
                'cart_id' => $row['crt_id'],
                'prd_id' => $row['prd_id'],
                'prd_name' => $row['prd_name'],
                'prd_price' => $row['prd_price'],
                'prd_img' => $row['prd_img'],
                'crt_amount' => $row['crt_amount'],
            ];

            $totalPrice += $row['prd_price'] * $row['crt_amount'];
        }
    } else {
        // ถ้าไม่มีสินค้าในตะกร้า
        echo '<p class="text-center my-3">ไม่มีสินค้าในตะกร้าของคุณ</p>';
        exit;
    }

    // ดึงข้อมูลที่อยู่และเบอร์โทรของผู้ใช้
    $userDetails = [];
    $sqlUser = "SELECT * FROM member WHERE mmb_id = $mmb_id";
    $resultUser = $proj_connect->query($sqlUser);

    if ($resultUser->num_rows > 0) {
        $userDetails = $resultUser->fetch_assoc();
    }
} else {
    // ถ้าผู้ใช้ไม่ได้ลงชื่อเข้าใช้
    echo '<p class="text-center my-3">โปรดลงชื่อเข้าใช้เพื่อดูตะกร้าสินค้าของคุณ</p>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Your E-commerce</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* Add your custom styles here */
    </style>
</head>

<body>

    <div class="container py-3">
        <h1 class="text-center my-3">Checkout</h1>

        <!-- แสดงข้อมูลที่อยู่และเบอร์โทร -->
        <div class="mb-4">
            <h4>ข้อมูลผู้ใช้</h4>
            <p>ชื่อ: <?php echo $userDetails['mmb_name'] . ' ' . $userDetails['mmb_surname']; ?></p>
            <p>ที่อยู่: <?php echo $userDetails['mmb_addr']; ?></p>
            <p>เบอร์โทร: <?php echo $userDetails['mmb_phone']; ?></p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">รหัสสินค้า</th>
                    <th scope="col">รูปสินค้า</th>
                    <th scope="col">ชื่อสินค้า</th>
                    <th scope="col">ราคา</th>
                    <th scope="col">จำนวน</th>
                    <th scope="col">ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartData as $item) : ?>
                    <tr>
                        <td><?php echo $item['prd_id']; ?></td>
                        <td>
                            <img src="startbootstrap-sb-admin-2-gh-pages/pages/product/<?php echo $item['prd_img']; ?>" alt="<?php echo $item['prd_name']; ?>" class="img-fluid" style="max-width: 100px;">
                        </td>
                        <td><?php echo $item['prd_name']; ?></td>
                        <td><?php echo $item['prd_price']; ?></td>
                        <td><?php echo $item['crt_amount']; ?></td>
                        <td><?php echo $item['prd_price'] * $item['crt_amount']; ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="5">ราคารวม</td>
                    <td><?php echo $totalPrice; ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Add your checkout form or button here -->

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add your custom scripts here -->

</body>

</html>