<?php
if (isset($_GET['mmb_id'])) {
    $mmb_id = $_GET['mmb_id'];

    // เชื่อมต่อกับฐานข้อมูล (ต้องเปลี่ยนการเชื่อมต่อตามของคุณ)
    require('connect/connect.php');

    $crt_ids = $_GET['crt_id'];
    $prd_ids = $_GET['prd_id'];
    $prd_name = $_GET['prd_name'];
    $crt_amounts = $_GET['crt_amount'];
    $item_totals = $_GET['itemTotal'];

    // ให้ $totalPrice เป็นผลรวมของราคาทั้งหมด
    $totalPrice = $_GET['totalPrice'];

    // ค้นหาข้อมูลสินค้าจากตาราง "product" โดยใช้ $prd_ids
    $sql = "SELECT product.prd_name, product.prd_img, member.mmb_name, member.mmb_surname, member.mmb_phone, member.mmb_addr ,member.mmb_email
            FROM cart
            INNER JOIN product ON cart.prd_id = product.prd_id
            INNER JOIN member ON cart.mmb_id = member.mmb_id
            WHERE cart.crt_id IN (" . implode(',', $crt_ids) . ")";
    $result = $proj_connect->query($sql);

    if ($result->num_rows > 0) {
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // แสดงข้อมูล
    } else {
        echo "ไม่พบข้อมูลสมาชิก";
    }
} else {
    echo "ไม่ได้รับค่าที่ต้องการ";
}
?>


<?php
// Assuming you have a connection to the database established


// Fetch data from the banking table
$banking_query = "SELECT * FROM banking";
$banking_result = $proj_connect->query($banking_query);

// Check if there are rows in the result
if ($banking_result->num_rows > 0) {
    $banks = $banking_result->fetch_all(MYSQLI_ASSOC);
} else {
    // Handle the case where no banks are found
    $banks = array();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include('mainweb_page/head.php'); ?>

<body>


<div class="container mt-5">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <h2>รายละเอียดการสั่งซื้อ</h2>
                <form action="insert_orders.php" method="POST" onSubmit="return(chkdata(this));">
                 
                <table class="table">
    <thead>
        <tr>
            <th scope="col">รหัสสินค้า</th>
            <th scope="col">ชื่อสินค้า</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ราคารวม</th>
      
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $index => $row) : ?>
            <tr>
            <td><?php echo $index + 1; ?></td>
                    <input type="hidden" name="prd_id[]" value="<?php echo $prd_ids[$index]; ?>">
                </td>
                
                <td><?php echo $row['prd_name']; ?>
               
                </td>
                <td><?php echo $crt_amounts[$index]; ?>
                    <input type="hidden" name="crt_amount[]" value="<?php echo $crt_amounts[$index]; ?>">
                </td>
                <td><?php echo $item_totals[$index]; ?> บาท
                    <input type="hidden" name="item_totals[]" value="<?php echo $item_totals[$index]; ?>">
                </td>

      
                <input type="hidden" name="crt_id[]" value="<?php echo $crt_ids[$index]; ?>">
             
                
            </tr>
        <?php endforeach; ?>
        <tfoot>
            <tr>
                <th>รวมเป็นเงิน</th>
                <th></th>
                <th></th>
                <th><?php echo $totalPrice; ?> บาท
                    <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
                </th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </tbody>
</table>

                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="mmb_id" value="<?php echo $mmb_id; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="mmb_name" class="form-label">ชื่อ-นามสกุล:</label>
                        <input type="text" class="form-control" name="mmb_name" >
                    </div>

                    <div class="mb-3">
                        <label for="mmb_phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" name="mmb_phone"  >
                    </div>

                    <div class="mb-3">
                        <label for="mmb_addr" class="form-label">ที่อยู่</label>
                        <textarea class="form-control" rows="3" name="mmb_addr" ></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mmb_email" class="form-label">อีเมล</label>
                        <input type="email" class="form-control" name="mmb_email">
                    </div>

                    <div class="mb-3">
                        <a href="address_add.php?mmb_id=<?php echo $mmb_id; ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> แก้ข้อมูลในการจัดส่ง
                        </a>
                    </div>
                    <div class="mb-3">
    <label for="pay_method" class="form-label">วิธีการชำระเงิน</label>

   
    <?php foreach ($banks as $bank) : ?>
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="pay_method" id="cash_on_delivery" value="จ่ายผ่านบัญชีธนาคาร">
        <label class="form-check-label" for="cash_on_delivery">
        จ่ายผ่านบัญชีธนาคาร <i class="fas fa-money-bill"></i><br>
                เลขบัญชี: <?php echo $bank['bank_number']; ?><br>
                <p class="text-danger">*กรุณาทำการแจ้งการชำระเงิน*</p>
                <img src="assets/img/<?php echo $bank['bank_img']; ?>" alt="Bank Image" width="300" height="500">
        </label>
    </div>
    <?php endforeach; ?>
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="pay_method" id="cash_on_delivery" value="เก็บเงินปลายทาง">
        <label class="form-check-label" for="cash_on_delivery">
        เก็บเงินปลายทาง <i class="fas fa-money-bill"></i>
        </label>
    </div>
</div>



                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Add this script block after including SweetAlert and before the closing </body> tag -->
<script>
    function chkdata(boarddata) {
        // Your existing form validation logic

        if (boarddata.mmb_name.value.trim() === "") {
            // Display SweetAlert notification for empty mmb_name
            Swal.fire({
                icon: 'error',
                title: 'กรุณาเพิ่มชื่อ',
                showConfirmButton: false,
                timer: 2000  // Close the alert after 2 seconds
            });

            return false;
        }

        if (boarddata.pay_method.value.trim() === "") {
            // Display SweetAlert notification for empty mmb_surname
            Swal.fire({
                icon: 'error',
                title: 'กรุณาเลือกวิธีการชำระเงิน',
                showConfirmButton: false,
                timer: 2000  // Close the alert after 2 seconds
            });

            return false;
        }

        if (boarddata.mmb_addr.value.trim() === "") {
            // Display SweetAlert notification for empty mmb_addr
            Swal.fire({
                icon: 'error',
                title: 'กรุณาเพิ่มที่อยู่',
                showConfirmButton: false,
                timer: 2000  // Close the alert after 2 seconds
            });

            return false;
        }

        if (boarddata.mmb_phone.value.trim() === "") {
            // Display SweetAlert notification for empty mmb_phone
            Swal.fire({
                icon: 'error',
                title: 'กรุณาเพิ่มเบอร์โทร',
                showConfirmButton: false,
                timer: 2000  // Close the alert after 2 seconds
            });

            return false;
        }

        if (boarddata.mmb_email.value.trim() === "") {
            // Display SweetAlert notification for empty mmb_email
            Swal.fire({
                icon: 'error',
                title: 'กรุณาเพิ่มอีเมล',
                showConfirmButton: false,
                timer: 2000  // Close the alert after 2 seconds
            });

            return false;
        }

        // Your existing form submission logic

        return true;
    }
</script>

<!-- Add this script block after including SweetAlert and before the closing </body> tag -->


    <?php include('mainweb_page/end_script.php'); ?>
</body>

</html>
