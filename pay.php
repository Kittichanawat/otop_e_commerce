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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve form data
        $order_id = $_POST['order_id'];
        $bank_info_id = $_POST['bank_info']; // ID from the radio input
        $pay_date = $_POST['pay_date'];
        $pay_time = $_POST['pay_time'];
        $pay_total = $_POST['pay_total'];

        // Fetch bank details based on selected bank info ID
        $bank_query = "SELECT * FROM banking WHERE id = ?";
        $bank_stmt = $proj_connect->prepare($bank_query);
        $bank_stmt->bind_param("i", $bank_info_id);
        $bank_stmt->execute();
        $bank_result = $bank_stmt->get_result();
        $bank_details = $bank_result->fetch_assoc();

        $bank_name = $bank_details['bank_name'];
        $acc_name = $bank_details['acc_name'];
        $bank_number = $bank_details['bank_number'];

        // Handle file upload for payment slip
        $target_dir = "pay/";
        $pay_img = $target_dir . basename($_FILES["pay_img"]["name"]);
        move_uploaded_file($_FILES["pay_img"]["tmp_name"], $pay_img);

        // Insert data into payment_notifications table
        $query = "INSERT INTO payment_notifications (order_id, bank_number, bank_name, acc_name, pay_date, pay_time, pay_total, pay_img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $proj_connect->prepare($query);
        $stmt->bind_param("isssssds", $order_id, $bank_number, $bank_name, $acc_name, $pay_date, $pay_time, $pay_total, $pay_img);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Update the status in orders table
            $update_query = "UPDATE orders SET status = 'รอตรวจสอบการชำระเงิน' WHERE order_id = ?";
            $update_stmt = $proj_connect->prepare($update_query);
            $update_stmt->bind_param("i", $order_id);
            $update_stmt->execute();
            $pay_success = true;
      
            $update_stmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>
    <header>
        <!-- Navbar -->
        <?php include('mainweb_page/nav_bar.php'); ?>
        <!-- Navbar -->





    </header>

    <main>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card shadow p-4 mb-3">
                        <h2 class="mx-auto">แจ้งการชำระเงิน</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="order_id" class="form-label">เลขที่ใบสั่งซื้อ</label>
                                <select class="form-control" id="order_id" name="order_id" required>
                                    <?php
                                    // สมมติว่าคุณมีการเชื่อมต่อฐานข้อมูลแล้ว
                                    $mmb_id = $_SESSION['mmb_id']; // รับ mmb_id จาก session
                                    $query = "SELECT order_id FROM orders WHERE mmb_id = $mmb_id AND status = 'รอการชำระเงิน'";
                                    $result = $proj_connect->query($query);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['order_id'] . '">' . $row['order_id'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="">ไม่มีคำสั่งซื้อ</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">เลือกบัญชีธนาคารที่ทำการชำระเงิน</label>
                                <?php
                                // สมมติว่าคุณมีการเชื่อมต่อฐานข้อมูลแล้ว
                                $query = "SELECT * FROM banking";
                                $result = $proj_connect->query($query);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <div class="card shadow-lg mb-3">
                                            <div class="card-body">
                                                <label class="card-radio-label">
                                                    <input class="form-check-input" type="radio" name="bank_info" id="bank<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>">
                                                    <img src="startbootstrap-sb-admin-2-gh-pages/pages/banking/<?php echo $row['bank_img']; ?>" alt="Bank A" class="img-fluid mb-2" width="40" height="40">
                                                    <?php echo $row['bank_name']; ?><br>
                                                    ชื่อบัญชี:<?php echo $row['acc_name']; ?><br>
                                                    เลขบัญชี:<?php echo $row['bank_number']; ?><br>
                                                </label>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>


                            <div class="mb-3">
                                <label for="pay_date" class="form-label">วันที่ทำการชำระเงิน</label>
                                <input type="date" class="form-control" id="pay_date" name="pay_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="pay_time" class="form-label">เวลาที่ทำการชำระเงิน</label>
                                <input type="time" class="form-control" id="pay_time" name="pay_time" required>
                            </div>
                            <div class="mb-3">
                                <label for="pay_total" class="form-label">จำนวนเงินที่ชำระ</label>
                                <input type="text" class="form-control" id="pay_total" name="pay_total" required>
                            </div>
                            <div class="mb-3">
                                <label for="pay_img" class="form-label">แนบสลิปการโอนเงิน</label>
                                <input type="file" class="form-control" id="pay_img" name="pay_img" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <?php if (isset($pay_success) && $pay_success) : ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'แจ้งการชำระเงินสำเร็จ',
            text: 'รอตรวจสอบหลักฐานการชำระเงิน',
            showConfirmButton: true, // แสดงปุ่ม OK
            confirmButtonText: 'OK', // แสดงข้อความบนปุ่ม
    
        }).then(function() {
            window.location.href = './';
        });
    </script>
<?php endif; ?>

    <!-- footer -->

    <?php include('mainweb_page/footer.php'); ?>

    <!-- footer -->


    <!-- end_script -->

    <?php include('mainweb_page/end_script.php'); ?>
    <!-- end_script -->


</body>

</html>