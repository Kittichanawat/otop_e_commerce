<?php
require_once('../../../connect/connect.php');
// Include your functions here

// Assuming your getOrdersCountByStatus and other count functions are defined here

$data = [
    'pendingOrderCount' => getOrdersCountByStatus('รอตรวจสอบการชำระเงิน'),
    'preparingForShippingCount' => getOrdersCountByStatus('รอดำเนินการจัดส่ง'),
    'traditionCount' => getCount('tradition'),
    'memberCount' => getCount('member'),
    
];

header('Content-Type: application/json');
echo json_encode($data);
?>
