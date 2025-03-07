<?php
// เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อตามของคุณ)
require('connect/connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมา
    $cartId = $_POST['cartId'];
    $action = $_POST['action'];

    // ตรวจสอบว่า cartId เป็นตัวเลขและ action เป็น 'increase' หรือ 'decrease'
    if (is_numeric($cartId) && ($action == 'increase' || $action == 'decrease')) {
        // ดึงข้อมูลสินค้าในตะกร้า
        $sql = "SELECT product.prd_price, product.amount AS maxAmount, cart.crt_amount FROM cart
                INNER JOIN product ON cart.prd_id = product.prd_id
                WHERE cart.crt_id = $cartId";
        $result = $proj_connect->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $prd_price = $row['prd_price'];
            $maxAmount = $row['maxAmount'];
            $crt_amount = $row['crt_amount'];

            if ($action == 'increase' && $crt_amount < $maxAmount) {
                // เพิ่มจำนวนสินค้า
                $crt_amount++;
            } elseif ($action == 'decrease' && $crt_amount > 1) {
                // ลดจำนวนสินค้า
                $crt_amount--;
            }

            // คำนวณราคารวมใหม่
            $itemTotal = $prd_price * $crt_amount;

            // อัปเดตจำนวนสินค้าและราคารวมในฐานข้อมูล
            $updateSql = "UPDATE cart SET crt_amount = $crt_amount WHERE crt_id = $cartId";
            if ($proj_connect->query($updateSql) === TRUE) {
                // ส่งข้อมูล JSON กลับไปยังหน้าเว็บ
                $response = array(
                    'success' => true,
                    'crtAmount' => $crt_amount,
                    'itemTotal' => $itemTotal,
                );

                // ตรวจสอบถ้าถึงจำนวนสูงสุดแล้ว
                $response['maxAmountReached'] = ($crt_amount == $maxAmount);

                echo json_encode($response);
            } else {
                // อัปเดตไม่สำเร็จ
                $response = array('success' => false);
                echo json_encode($response);
            }
        } else {
            // ไม่พบข้อมูลตะกร้าสินค้า
            $response = array('success' => false);
            echo json_encode($response);
        }
    } else {
        // ข้อมูลไม่ถูกต้อง
        $response = array('success' => false);
        echo json_encode($response);
    }
}
?>
