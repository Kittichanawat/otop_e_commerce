<?php
require_once('../../../connect/connect.php');

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

$pendingOrderCount = getOrdersCountByStatus('รอตรวจสอบการชำระเงิน');
$preparingForShippingCount = getOrdersCountByStatus('รอดำเนินการจัดส่ง');

$response = array(
    'pendingOrderCount' => $pendingOrderCount,
    'preparingForShippingCount' => $preparingForShippingCount
);

echo json_encode($response);
?>
