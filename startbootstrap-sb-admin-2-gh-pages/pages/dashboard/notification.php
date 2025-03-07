<?php
// Fetch the latest order
require('../connectPDO/connnectpdo.php');
$stmt = $conn->query("SELECT orders.order_id, member.mmb_name, member.mmb_surname, orders.status
                      FROM orders
                      JOIN member ON orders.mmb_id = member.mmb_id
                      ORDER BY orders.created_at DESC
                      LIMIT 1");
$stmt->execute();
$newOrder = $stmt->fetch(PDO::FETCH_ASSOC);

// Output the order details as JSON
echo json_encode($newOrder);
?>
