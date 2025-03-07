<?php


require('../../../connect.php');
// ต่อไปเราสามารถใช้ $mmb_username เพื่อแสดงชื่อผู้ใช้ในหน้าเว็บของคุณได้
?>


<?php
require('../../../connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['status']) && isset($_GET['order_id'])) {
        $newStatus = $_POST['status'];
        $orderId = $_GET['order_id'];
        $parcelId = isset($_POST['parcel_id']) ? $_POST['parcel_id'] : null; // รับค่าหมายเลขการจัดส่งจากฟอร์ม
        $parcelName = isset($_POST['parcel_name']) ? $_POST['parcel_name'] : null; // รับค่าชื่อผู้รับพัสดุจากฟอร์ม

        // Update the status, parcel ID, and parcel name of the order in the database
        $updateSql = "UPDATE orders SET status = ?, parcel_id = ?, parcel_name = ? WHERE order_id = ?";
        $stmt = $proj_connect->prepare($updateSql);
        $stmt->bind_param("sssi", $newStatus, $parcelId, $parcelName, $orderId);

        if ($stmt->execute()) {
            // Redirect back to the same page after updating
            $registration_success = true;
        } else {
            echo "เกิดข้อผิดพลาดในการอัพเดตสถานะ: " . $proj_connect->error;
        }

        $stmt->close();
    } else {
        echo "โปรดระบุสถานะและหมายเลขการจัดส่งสำหรับการแก้ไข";
    }
}
?>



<!-- head -->



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
<!DOCTYPE html>
<html lang="en">

<?php include('../../web_stuc/head.php'); ?>

<body id="page-top">



    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('../../web_stuc/side_bar.php'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include('../../web_stuc/top_bar.php'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <div class="container pt-5">
    <!-- Display order details -->
    <article class="card mb-3">
        <header class="card-header"><a href="index.php">กลับหน้ารายการคำสั่งซื้อ</a> </header>
        <div class="card-body">
            <h6>เลขที่ใบสั่งซื้อ: <?php echo str_pad($orderDetails['order_id'], 10, "0", STR_PAD_LEFT); ?>
                <span class="badge bg-danger mb-0 float-end"><?php echo $orderDetails['status']; ?></span>
            </h6>
            <div class="row">
                <div class="col-md-6">
                    <?php
                    // Fetch shipping information from ship_info table
                    $shipInfoSql = "SELECT * FROM ship_info WHERE order_id = ?";
                    $shipInfoStmt = $proj_connect->prepare($shipInfoSql);
                    $shipInfoStmt->bind_param("i", $order_id);
                    $shipInfoStmt->execute();
                    $shipInfoResult = $shipInfoStmt->get_result();

                    if ($shipInfoResult->num_rows > 0) {
                        $shipInfoRow = $shipInfoResult->fetch_assoc();
                        ?>
                        <p><strong>ชื่อผู้รับสินค้า:</strong> <?php echo $shipInfoRow['mmb_name'] . " " . $shipInfoRow['mmb_surname']; ?></p>
                        <p><strong>ที่อยู่:</strong> <?php echo $shipInfoRow['mmb_addr']; ?></p>
                        <p><strong>เบอร์โทร:</strong> <?php echo $shipInfoRow['mmb_phone']; ?></p>
                    <?php } else {
                        echo "<p>ไม่พบข้อมูลการจัดส่งสำหรับคำสั่งซื้อนี้</p>";
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <!-- Display additional order details here -->
                </div>
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
                                <th>ไฟล์</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item) : ?>

                                <tr>
                                    <td>
                                        <img src="../product/<?php echo $item['prd_img']; ?>" alt="Product Image" style="height: 50px;"> <!-- Display product image -->
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
                    <div class="modal fade" id="payImgModalall<?php echo $orderDetails['order_id']; ?>" tabindex="-1" aria-labelledby="payImgModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="payImgModalLabel">หลักฐานการชำระเงิน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="<?php echo $orderDetails['order_id']; ?>" class="img-fluid" alt="Payment Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>No items found for this order.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
        <?php if ($orderDetails['status'] == 'รอตรวจสอบการชำระเงิน' || $orderDetails['status'] == 'รอดำเนินการจัดส่ง') : ?>
            <form action="" method="post">
                <label for="status">สถานะ:</label>
                <select name="status" id="status" class="form-select">
                    <?php if ($orderDetails['status'] == 'รอตรวจสอบการชำระเงิน') : ?>
                        <option value="รอดำเนินการจัดส่ง">รอดำเนินการจัดส่ง</option>
                        <option value="ยกเลิก">ยกเลิก</option>
                    <?php elseif ($orderDetails['status'] == 'รอดำเนินการจัดส่ง') : ?>
                        <option value="จัดส่งสินค้าแล้ว">จัดส่งแล้ว</option>
                        <option value="ยกเลิก">ยกเลิก</option>
                    <?php endif; ?>
                </select>
                <?php if ($orderDetails['status'] == 'รอดำเนินการจัดส่ง') : ?>
                    <div class="form-group">
                        <label for="parcel_name">ชื่อบริษัทขนส่ง:</label>
                        <input type="text" name="parcel_name" id="parcel_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="parcel_id">หมายเลขการจัดส่ง:</label>
                        <input type="text" name="parcel_id" id="parcel_id" class="form-control">
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary mt-3">บันทึก</button>
            </form>
            <?php endif; ?>
        </div>
    </article>
</div>



                <script>
                    // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จ
                    window.onload = function() {
                        // ซ่อน input parcel_id เมื่อหน้าเว็บโหลดเสร็จ
                        document.getElementById("parcelIdField").style.display = "none";

                        // เมื่อมีการเปลี่ยนแปลงใน dropdown status
                        document.getElementById("status").addEventListener("change", function() {
                            var status = this.value; // รับค่า status ที่เลือก

                            // ถ้า status เป็น 'รอดำเนินการจัดส่ง' ให้แสดง input parcel_id มิฉะนั้นให้ซ่อน
                            if (status === 'รอดำเนินการจัดส่ง') {
                                document.getElementById("parcelIdField").style.display = "block";
                            } else {
                                document.getElementById("parcelIdField").style.display = "none";
                            }
                        });
                    };
                </script>








                <!-- Add more product details as needed -->


                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('../../web_stuc/footer.php'); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id, title, bankNumber) {
            Swal.fire({
                title: 'ยืนยันการลบข้อมูล',
                html: `คุณต้องการลบข้อมูล "${title}" ที่มีหมายเลขบัญชี "${bankNumber}" ใช่หรือไม่?`, // ใช้ html แทน text เพื่อรองรับข้อความที่มีการรูปแบบพิเศษ
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ถ้าผู้ใช้กดยืนยันการลบ
                    fetch(`orders_delete.php?id=${id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('ลบสำเร็จ', 'ข้อมูลได้ถูกลบเรียบร้อย', 'success').then(() => {
                                    // รีโหลดหน้าหลังจากลบสำเร็จ
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('ลบไม่สำเร็จ', 'เกิดข้อผิดพลาดในการลบข้อมูล', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('เกิดข้อผิดพลาดในการส่งคำร้องขอ: ', error);
                            Swal.fire('ข้อผิดพลาด', 'ไม่สามารถลบข้อมูลได้', 'error');
                        });
                }
            });
        }
    </script>

    <script>
        function confirmDeleteSelect() {
            // Find all selected checkboxes
            const checkboxes = document.querySelectorAll('input[name="delete[]"]:checked');

            if (checkboxes.length === 0) {
                // No checkboxes selected, prevent form submission
                Swal.fire('No Items Selected', 'Please select the items you want to delete', 'error');
                return false;
            }

            Swal.fire({
                title: 'Confirm Deletion',
                text: `Are you sure you want to delete ${checkboxes.length} items?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user confirms the deletion, proceed with the AJAX request
                    deleteSelectedItems(checkboxes);
                } else {
                    // If the user cancels the deletion, prevent form submission
                    return false;
                }
            });
        }

        function deleteSelectedItems(checkboxes) {
            const Ids = Array.from(checkboxes).map(checkbox => checkbox.value);

            fetch('delete_records.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        Ids: Ids
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Deletion Successful', 'Items have been deleted successfully', 'success').then(() => {
                            // Reload the page or take any other necessary action
                            window.location.reload();
                        });
                    } else {
                        Swal.fire('Deletion Failed', 'An error occurred during deletion', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error sending request:', error);
                    Swal.fire('Error', 'Unable to delete items', 'error');
                });
        }
    </script>


    <script>
        // Function to handle the "Select All" checkbox
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="delete[]"]');

            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        // Attach the event listener to the "Select All" checkbox
        const selectAllCheckbox = document.getElementById('selectAll');
        selectAllCheckbox.addEventListener('change', toggleSelectAll);
    </script>









    <?php if (isset($registration_success) && $registration_success) : ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'สมัครสมาชิกสำเร็จ',
                text: 'คุณสามารถเข้าสู่ระบบได้เดี่ยวนี้',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = 'index.php';
            });
        </script>
    <?php endif; ?>





    <?php include('../../web_stuc/end_script.php'); ?>

</body>

</html>