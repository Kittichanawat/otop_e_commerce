<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('../../web_stuc/head.php');?>

    <style>
        .notification-icon {
    position: relative;
    cursor: pointer;
}

.badge-danger {
    position: absolute;
    top: -10px;
    right: -10px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="notification-icon">
            <i class="fa fa-envelope"></i>
            <span class="badge badge-danger" id="newOrderCount">0</span>
        </div>

        <!-- Modal or Dropdown to show order details -->
        <div id="orderDetails" class="modal">
            <!-- Order details will be populated here -->
        </div>
    </div>
<script>

document.addEventListener('DOMContentLoaded', function() {
    fetchNotifications();

    // Add click event for notification icon
    document.querySelector('.notification-icon').addEventListener('click', function() {
        // Fetch and display order details
        fetchNotifications();
    });
});

function fetchNotifications() {
    fetch('fetch_notifications.php')
    .then(response => response.json())
    .then(data => {
        document.getElementById('newOrderCount').innerText = data.unreadCount;

        // Populate order details in the modal or dropdown
        var orderDetails = document.getElementById('orderDetails');
        orderDetails.innerHTML = ''; // Clear previous content
        data.orders.forEach(order => {
            orderDetails.innerHTML += `<div>Order ID: ${order.order_id} - ${order.totalPrice}</div>`;
        });
    })
    .catch(error => console.error('Error:', error));
}

</script>
<?php include('../../web_stuc/end_script.php');?>
</body>
</html>