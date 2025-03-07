<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    session_start();
    // Get data from the form
    $mmb_id = $_POST['mmb_id'];
    $pay_method = $_POST['pay_method'];
    $totalPrice = $_POST['totalPrice'];
    $mmb_name = $_POST['mmb_name'];
    $mmb_surname = $_POST['mmb_surname'];
    $mmb_addr = $_POST['mmb_addr'];
    $mmb_email = $_POST['mmb_email'];
    $mmb_phone = $_POST['mmb_phone'];

    // Assuming you have a connection to the database established
    require('connect/connect.php');

    // Set the default status value
    $status = 'รอการชำระเงิน';

    // Check the pay_method value
    if ($pay_method == 'เก็บเงินปลายทาง') {
        $status = 'รอดำเนินการจัดส่ง';
    }

    // Insert order data
    $insert_orders_query = "INSERT INTO orders (mmb_id, status, pay_method,  totalPrice) VALUES ($mmb_id, '$status', '$pay_method', $totalPrice)";
    $proj_connect->query($insert_orders_query);

    // Get the last inserted order_id
    $order_id = $proj_connect->insert_id;

    // Insert ship_info data
    $insert_ship_info_query = "INSERT INTO ship_info (order_id, mmb_name, mmb_surname, mmb_addr, mmb_phone) 
                               VALUES ($order_id, '$mmb_name', '$mmb_surname', '$mmb_addr', '$mmb_phone')";
    $proj_connect->query($insert_ship_info_query);

    // Insert order_detail data
    $prd_ids = $_POST['prd_id'];
    $crt_ids = $_POST['crt_id'];
    $crt_amounts = $_POST['crt_amount'];
    $item_totals = $_POST['item_totals'];
    $prd_names = $_POST['prd_name']; // New line to get prd_name values

    foreach ($prd_ids as $index => $prd_id) {
        // Use prepared statements to prevent SQL injection
        $insert_order_detail_query = $proj_connect->prepare("INSERT INTO order_detail (order_id, crt_id, mmb_id, prd_id, crt_amount, item_totals, prd_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_order_detail_query->bind_param("iiisids", $order_id, $crt_ids[$index], $mmb_id, $prd_id, $crt_amounts[$index], $item_totals[$index], $prd_names[$index]);
        $insert_order_detail_query->execute();

        // Deduct the ordered quantity from the product amount
        $update_product_query = "UPDATE product SET amount = amount - ? WHERE prd_id = ?";
        $update_product_statement = $proj_connect->prepare($update_product_query);
        $update_product_statement->bind_param("ii", $crt_amounts[$index], $prd_id);
        $update_product_statement->execute();

        // Check if the updated amount is zero and update prd_show accordingly
        $check_zero_query = "UPDATE product SET prd_show = 0 WHERE amount = 0 AND prd_id = ?";
        $check_zero_statement = $proj_connect->prepare($check_zero_query);
        $check_zero_statement->bind_param("i", $prd_id);
        $check_zero_statement->execute();
    }

    // Close the prepared statements
    $insert_order_detail_query->close();
    $update_product_statement->close();
    $check_zero_statement->close();

    // Delete items from the cart
    foreach ($crt_ids as $crt_id) {
        $delete_cart_item_query = "DELETE FROM cart WHERE crt_id = $crt_id";
        $proj_connect->query($delete_cart_item_query);
    }

    // Storing order ID and total price in session
    $_SESSION['order_id'] = $order_id;
    $_SESSION['totalPrice'] = $totalPrice;

    // Store session crt_success
    $_SESSION['crt_success'] = true;

    // Close the database connection
    $proj_connect->close();

    // Redirect to a success page or perform additional actions
    $order_success = true;

} else {
    // Handle the case where the form was not submitted
    echo "Form not submitted.";
}

// After successfully saving data
if ($order_success) {
    // Send JSON response back to checkout_copy.php
    echo json_encode(array('success' => true));
} else {
    // Send JSON response back to checkout_copy.php with an error message (if any)
    echo json_encode(array('success' => false, 'message' => 'เกิดข้อผิดพลาดในการสั่งซื้อ'));
}

if (session_status() == PHP_SESSION_ACTIVE) {
    unset($_SESSION['crt_success']);
}
?>

