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

                <h1 class=" text-center ">หน้าจัดการคำสั่งซื้อ</h1>
                <a href="orders_add.php" class="text-left mb-3 ml-3 btn btn-primary">เพิ่มธนาคาร </a>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="all-orders-tab" data-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">คำสั่งซื้อทั้งหมด</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pending-payment-tab" data-toggle="tab" href="#pending-payment" role="tab" aria-controls="pending-payment" aria-selected="false">รอการชำระเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pending-verification-tab" data-toggle="tab" href="#pending-verification" role="tab" aria-controls="pending-verification" aria-selected="false">รอตรวจสอบการชำระเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pending-shipping-tab" data-toggle="tab" href="#pending-shipping" role="tab" aria-controls="pending-shipping" aria-selected="false">รอดำเนินการจัดส่ง</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="shipped-tab" data-toggle="tab" href="#shipped" role="tab" aria-controls="shipped" aria-selected="false">จัดส่งแล้ว</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">ยกเลิก</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
                        <!-- เนื้อหาสำหรับคำสั่งซื้อทั้งหมด -->
                        <table id="myTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขใบสั่งซื้อ</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ราคารวม</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                    <th></th>

                                 
                                </tr>
                            </thead>
                            <tbody>
                            <?php
    require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
    $stmt = $conn->query("SELECT orders.*, ship_info.mmb_name, ship_info.mmb_surname, payment_notifications.pay_img 
                          FROM orders 
                          INNER JOIN ship_info ON orders.order_id = ship_info.order_id 
                          LEFT JOIN payment_notifications ON orders.order_id = payment_notifications.order_id
                          ");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 1; // เริ่มต้นลำดับที่ 1
    foreach ($students as $student) {
    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
                                        <td><?php echo $student['order_id'] ?></td>
                                        <td><?php echo $student['mmb_name'] . ' ' . $student['mmb_surname']; ?></td>

                                        <td><?php echo $student['totalPrice'] ?></td>
                                        <td><?php echo $student['created_at'] ?></td>
                                        <td><?php echo $student['status'] ?></td>
                                         <td><?php if (!empty($student['pay_img'])) : ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#payImgModalall<?php echo $student['order_id'] ?>">
                        <i class="fas fa-paperclip"></i>
                    </a>
                <?php else : ?>
                    <span></span>
                <?php endif; ?></td>

                                        <td><a href="order_detail.php?order_id=<?php echo $student['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i>ดูข้อมูล</a></td>
                                       
                                    </tr>
                                    <div class="modal fade" id="payImgModalall<?php echo $student['order_id'] ?>" tabindex="-1" aria-labelledby="payImgModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payImgModalLabel">หลักฐานการชำระเงิน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($student['pay_img'])) : ?>
                            <img src="../../../<?php echo $student['pay_img']; ?>" class="img-fluid" alt="Payment Image">
                        <?php else : ?>
                            <p>No payment image available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pending-payment" role="tabpanel" aria-labelledby="pending-payment-tab">
                        <!-- เนื้อหาสำหรับคำสั่งซื้อที่รอการชำระเงิน -->
                        <table id="pendingPaymentTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขใบสั่งซื้อ</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ราคารวม</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>สถานะ</th>
                                    <th></th>
                           
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
                                $stmt = $conn->query("SELECT orders.*, ship_info.mmb_name, ship_info.mmb_surname 
                      FROM orders 
                      INNER JOIN ship_info ON orders.order_id = ship_info.order_id 
                      WHERE orders.status = 'รอการชำระเงิน'");
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1; // เริ่มต้นลำดับที่ 1
                                foreach ($students as $student) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
                                        <td><?php echo $student['order_id'] ?></td>
                                        <td><?php echo $student['mmb_name'] . ' ' . $student['mmb_surname']; ?></td>
                                        <td><?php echo $student['totalPrice'] ?></td>
                                        <td><?php echo $student['created_at'] ?></td>
                                        <td><?php echo $student['status'] ?></td>
                                        <td><a href="order_detail.php?order_id=<?php echo $student['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i>ดูข้อมูล</a></td>
                                 
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pending-shipping" role="tabpanel" aria-labelledby="pending-shipping-tab">
                        <!-- เนื้อหาสำหรับคำสั่งซื้อที่รอตรวจสอบการชำระเงิน -->
                        <table id="pendingshipping" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขใบสั่งซื้อ</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ราคารวม</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>สถานะ</th>
                                    <th></th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
                                $stmt = $conn->query("SELECT orders.*, ship_info.mmb_name, ship_info.mmb_surname 
                      FROM orders 
                      INNER JOIN ship_info ON orders.order_id = ship_info.order_id 
                      WHERE orders.status = 'รอดำเนินการจัดส่ง'");
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1; // เริ่มต้นลำดับที่ 1
                                foreach ($students as $student) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
                                        <td><?php echo $student['order_id'] ?></td>
                                        <td><?php echo $student['mmb_name'] . ' ' . $student['mmb_surname']; ?></td>
                                        <td><?php echo $student['totalPrice'] ?></td>
                                        <td><?php echo $student['created_at'] ?></td>
                                        <td><?php echo $student['status'] ?></td>
                                        <td><a href="order_detail.php?order_id=<?php echo $student['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i>ดูข้อมูล</a></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pending-verification" role="tabpanel" aria-labelledby="pending-verification-tab">
                        <!-- เนื้อหาสำหรับคำสั่งซื้อที่จัดส่งแล้ว -->
                        <table id="pendingverification" class="table table-striped" style="width:100%">
                        <thead>
    <tr>
        <th>ลำดับ</th>
        <th>เลขใบสั่งซื้อ</th>
        <th>ชื่อผู้สั่ง</th>
        <th>ราคารวม</th>
        <th>วันที่สั่งซื้อ</th>
        <th>สถานะ</th>
        <th>ไฟล์</th>
        <th></th>
      
    </tr>
</thead>
<tbody>
    <?php
    require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
    $stmt = $conn->query("SELECT orders.*, ship_info.mmb_name, ship_info.mmb_surname, payment_notifications.pay_img 
                          FROM orders 
                          INNER JOIN ship_info ON orders.order_id = ship_info.order_id 
                          LEFT JOIN payment_notifications ON orders.order_id = payment_notifications.order_id
                          WHERE orders.status = 'รอตรวจสอบการชำระเงิน'");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $i = 1; // เริ่มต้นลำดับที่ 1
    foreach ($students as $student) {
    ?>
        <tr>
            <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
            <td><?php echo $student['order_id'] ?></td>
            <td><?php echo $student['mmb_name'] . ' ' . $student['mmb_surname']; ?></td>
            <td><?php echo $student['totalPrice'] ?></td>
            <td><?php echo $student['created_at'] ?></td>
            <td><?php echo $student['status'] ?></td>
            <td>
                <?php if (!empty($student['pay_img'])) : ?>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#payImgModal<?php echo $student['order_id'] ?>">
                        <i class="fas fa-paperclip"></i>
                    </a>
                <?php else : ?>
                    <span>N/A</span>
                <?php endif; ?>
            </td>
            <td><a href="order_detail.php?order_id=<?php echo $student['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i>ดูข้อมูล</a></td>
         
        </tr>
        <!-- Modal -->
        <div class="modal fade" id="payImgModal<?php echo $student['order_id'] ?>" tabindex="-1" aria-labelledby="payImgModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="payImgModalLabel">หลักฐานการชำระเงิน</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (!empty($student['pay_img'])) : ?>
                            <img src="../../../<?php echo $student['pay_img']; ?>" class="img-fluid" alt="Payment Image">
                        <?php else : ?>
                            <p>No payment image available.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</tbody>
                        </table>

                    </div>
                    <div class="tab-pane fade" id="shipped" role="tabpanel" aria-labelledby="shipped-tab">
                        <!-- เนื้อหาสำหรับคำสั่งซื้อที่จัดส่งแล้ว -->
                        <table id="shippedTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขใบสั่งซื้อ</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ราคารวม</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>สถานะ</th>
                                    <th>เลขขนส่ง</th>
                                    <th>ขนส่ง</th>
                                    <th></th>
                               
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
                                $stmt = $conn->query("SELECT orders.*, ship_info.mmb_name, ship_info.mmb_surname 
                      FROM orders 
                      INNER JOIN ship_info ON orders.order_id = ship_info.order_id 
                      WHERE orders.status = 'จัดส่งสินค้าแล้ว'");
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1; // เริ่มต้นลำดับที่ 1
                                foreach ($students as $student) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
                                        <td><?php echo $student['order_id'] ?></td>
                                        <td><?php echo $student['mmb_name'] . ' ' . $student['mmb_surname']; ?></td>
                                        <td><?php echo $student['totalPrice'] ?></td>
                                        <td><?php echo $student['created_at'] ?></td>
                                        <td><?php echo $student['status'] ?></td>
                                        <td><?php echo $student['parcel_id'] ?></td>
                                        <td><?php echo $student['parcel_name'] ?></td>
                                        <td><a href="order_detail.php?order_id=<?php echo $student['order_id'] ?>" class="btn btn-info"><i class="fa-solid fa-magnifying-glass"></i>ดูข้อมูล</a></td>
                                        
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <!-- เนื้อหาสำหรับคำสั่งซื้อที่ถูกยกเลิก -->
                        <table id="cancelledTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขใบสั่งซื้อ</th>
                                    <th>ชื่อผู้สั่ง</th>
                                    <th>ราคารวม</th>
                                    <th>วันที่สั่งซื้อ</th>
                                    <th>สถานะ</th>
                          
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require('../connectPDO/connnectpdo.php'); // ตรวจสอบชื่อไฟล์ให้ถูกต้อง
                                $stmt = $conn->query("SELECT orders.*, ship_info.mmb_name, ship_info.mmb_surname 
                      FROM orders 
                      INNER JOIN ship_info ON orders.order_id = ship_info.order_id 
                      WHERE orders.status = 'ยกเลิก'");
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                $i = 1; // เริ่มต้นลำดับที่ 1
                                foreach ($students as $student) {
                                ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td> <!-- แสดงลำดับ -->
                                        <td><?php echo $student['order_id'] ?></td>
                                        <td><?php echo $student['mmb_name'] . ' ' . $student['mmb_surname']; ?></td>
                                        <td><?php echo $student['totalPrice'] ?></td>
                                        <td><?php echo $student['created_at'] ?></td>
                                        <td><?php echo $student['status'] ?></td>
                                 
                                        <td><a onclick="confirmDelete(<?php echo  $student['id']; ?>, '<?php echo  $student['title']; ?>')" class="btn btn-danger">ลบ</a></td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>










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















    <?php include('../../web_stuc/end_script.php'); ?>

</body>

</html>