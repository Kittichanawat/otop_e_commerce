<!DOCTYPE html>
<html lang="en">

<!-- head -->

<?php include('../../web_stuc/head.php'); ?>


<!-- head -->

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
                <div class="content">
                <?php
require_once('../../../connect/connect.php');

// Function to get the count of records in a table
function getCount($table) {
    global $proj_connect;
    $query = "SELECT COUNT(*) as count FROM $table";
    $result = $proj_connect->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    return 0;
}

// Function to get the count of orders with a specific status
function getOrdersCountByStatus($status) {
    global $proj_connect;
    $query = "SELECT COUNT(*) as count FROM orders WHERE status = ?";
    $stmt = $proj_connect->prepare($query);
    $stmt->bind_param("s", $status); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    return 0;
}

// Get counts for each table
$memberCount = getCount('member');
$productCount = getCount('product');
$touristCount = getCount('tourist');
$traditionCount = getCount('tradition');
$pendingOrderCount = getOrdersCountByStatus('รอตรวจสอบการชำระเงิน'); // Orders with the status "รอตรวจสอบการชำระเงิน"
$preparingForShippingCount = getOrdersCountByStatus('รอดำเนินการจัดส่ง'); // Orders with the status "รอดำเนินการจัดส่ง"

// Get the total website visitor count from the page_views table
$visitorCount = 0; // Initialize the count to 0
$query = "SELECT SUM(view_count) as total_count FROM page_views";
$result = $proj_connect->query($query);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $visitorCount = $row['total_count'];
}
?>


<script>
    $(document).ready(function(){
    function updateCounts() {
        $.ajax({
            type: "GET",
            url: "updateCounts.php", // แก้ไขเป็นไฟล์ที่มีการดึงข้อมูลจำนวนสินค้า
            success: function(response){
                var data = JSON.parse(response);
                $('#pendingOrderCount').text(data.pendingOrderCount);
                $('#preparingForShippingCount').text(data.preparingForShippingCount);
            }
        });
    }

    // อัพเดทข้อมูลทุก 3 วินาที
    setInterval(updateCounts, 3000);
});

</script>
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
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">สินค้ารอตรวจสอบการชำระเงิน <i class="fa-solid fa-box"></i></h5>
                                 
                                        <p class="card-text h1 text-danger" id="pendingOrderCount"><?php echo $pendingOrderCount; ?> </p>

                                      
                                            <a href="../order" class="btn btn-primary">ตรวจสอบ</a>   
                                               
                                            
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">สินค้ารอดำเนินการจัดส่ง<i class="fa-solid fa-location-dot"></i></h5>
                                    
                                        <p class="card-text h1 text-danger" id="preparingForShippingCount"><?php echo $preparingForShippingCount; ?> </p>

                                       
                                        <a href="../order" class="btn btn-primary">ตรวจสอบ</a>  
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">ประเพณี <i class="fa-solid fa-tent-arrow-left-right"></i></h5>
                                        <p class="card-text">จำนวนประเพณี: <?php echo $traditionCount; ?> ประเพณี</p>
                                        <p class="card-text"><a href="../tradition/" class="btn btn-primary">จัดการประเพณี <i class="fa-solid fa-arrow-pointer"></i></a> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">สมาชิก <i class="fa-solid fa-users"></i></h5>
                                        <p class="card-text">จำนวนสมาชิกทั้งหมด: <?php echo $memberCount; ?> คน</p>
                                        <p class="card-text"><a href="../member/" class="btn btn-primary">จัดการสมาชิก <i class="fa-solid fa-arrow-pointer"></i></a> </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Centered and stretched card for website visitors -->
                            <div class="col-lg-12 mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">ผู้เข้าชมเว็บไซต์ <i class="fa-solid fa-eye"></i></h5>
                                        <p class="card-text text-center">จำนวนผู้เข้าชมเว็บไซต์: <?php echo $visitorCount; ?> ครั้ง</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="container mt-5">
                        <div class="card">
                            <div class="card-body">
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>เลขที่การสั่งซื้อ</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>สถานะการสั่งซื้อ</th>
                                            <th>เวลาที่สั่งซื้อ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require('../connectPDO/connnectpdo.php');
                                        $stmt = $conn->query("SELECT orders.order_id, orders.created_at, member.mmb_name, member.mmb_surname, orders.status FROM orders JOIN member ON orders.mmb_id = member.mmb_id WHERE orders.status = 'รอการชำระเงิน'");
                                        $stmt->execute();
                                        $hasRecords = false;
                                        $orders = $stmt->fetchAll();
                                        foreach ($orders as $order) {
                                            $hasRecords = true;
                                        ?>
                                            <tr>
                                                <td><?php echo $order['order_id']; ?></td>
                                                <td><?php echo $order['mmb_name'] . '&nbsp;&nbsp;&nbsp;' . $order['mmb_surname']; ?></td>

                                                <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $order['status']; ?></td>
                                                <td class="text-truncate overflow-hidden" style="max-width: 200px;"><?php echo $order['created_at']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


      



                    <script>
                        $(document).ready(function() {
                            function fetchNotifications() {
                                $.ajax({
                                    url: 'fetch_notifications.php',
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function(notifications) {
                                        var count = notifications.length;
                                        $('.notification-count').text(count);

                                        // Clear current notifications
                                        $('#notification-dropdown').empty();

                                        // Add new notifications
                                        notifications.forEach(function(notification) {
                                            $('#notification-dropdown').append('<div class="notification-item">' +
                                                'Order ID: ' + notification.order_id +
                                                ' - Time: ' + notification.created_at +
                                                '</div>');
                                        });
                                    }
                                });
                            }

                            // Fetch notifications on page load
                            fetchNotifications();

                            // Set interval to fetch notifications periodically
                            setInterval(fetchNotifications, 30000); // Every 30 seconds

                            // Event listener for clicking a notification
                            $('#notification-dropdown').on('click', '.notification-item', function() {
                                var order_id = $(this).data('order-id');

                                // Mark as read
                                $.ajax({
                                    url: 'mark_as_read.php',
                                    type: 'POST',
                                    data: {
                                        order_id: order_id
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.status === 'success') {
                                            // Reload notifications
                                            fetchNotifications();
                                        }
                                    }
                                });
                            });

                            // Toggle notification dropdown
                            $('.notification-icon').click(function() {
                                $('#notification-dropdown').toggle();
                            });
                        });
                    </script>












                    <!-- Bell Icon -->








                    <div id="notificationIcon" style="cursor: pointer; position: fixed; bottom: 20px; right: 20px;">
                        <img src="notification_icon.png" alt="Notification Icon" width="40" height="40">
                    </div>

                    <div id="orderDetailsPopup" style="display: none; position: fixed; bottom: 80px; right: 20px; padding: 10px; background-color: white; border: 1px solid #ccc; border-radius: 5px;">
                        <h5>New Order Received</h5>
                        <p id="orderDetails"></p>
                    </div>

                    <!-- Rest of your HTML content -->

                    <!-- Add this script at the end of the <body> tag -->
                    <script>
                        // ... (previous JavaScript code)

                        // Add click event listener to the notification icon
                        document.getElementById("notificationIcon").addEventListener("click", function() {
                            // Display the order details popup
                            document.getElementById("orderDetailsPopup").style.display = "block";
                        });

                        // Function to hide the order details popup
                        function hideOrderDetailsPopup() {
                            document.getElementById("orderDetailsPopup").style.display = "none";
                        }

                        // Check for new orders every X seconds
                        function checkForNewOrders() {
                            fetch("notification.php")
                                .then(response => response.json())
                                .then(data => {
                                    showNotification(data);
                                    displayOrderDetails(data);
                                })
                                .catch(error => console.error("Error fetching new orders:", error));
                        }

                        // Function to display order details in the popup
                        function displayOrderDetails(order) {
                            if (order) {
                                document.getElementById("orderDetails").innerHTML = `
            Order ID: ${order.order_id}<br>
            Name: ${order.mmb_name} ${order.mmb_surname}<br>
            Status: ${order.status}
        `;
                            }
                        }

                        // Close the order details popup when clicked outside of it
                        document.addEventListener("click", function(event) {
                            if (!event.target.closest("#orderDetailsPopup") && !event.target.closest("#notificationIcon")) {
                                hideOrderDetailsPopup();
                            }
                        });

                        // Hide the order details popup initially
                        hideOrderDetailsPopup();
                    </script>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



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
    <!-- end_script -->
    <!-- Bootstrap core JavaScript-->
    <?php include('../../web_stuc/end_script.php'); ?>



</body>

</html>