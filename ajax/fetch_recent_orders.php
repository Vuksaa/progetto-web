<?php
include("../fragments/connection-begin.php");
session_start();
// only select the orders that were created in the last 24 hours
if ($allOrders = $conn->query(
  "SELECT o.order_id, o.order_address, p.product_name, s.status_name, s.status_id, po.notes, po.quantity, o.creation_timestamp
  FROM uni_web_prod.order o
  JOIN product_order po
  ON o.order_id = po.order_id
  JOIN product p
  ON po.product_id = p.product_id
  LEFT JOIN status s
  ON o.status_id = s.status_id
  WHERE p.provider_id = '".$_SESSION['user_id']."'
  AND DATE_SUB(NOW(), INTERVAL 1 DAY) < o.creation_timestamp
  ORDER BY o.creation_timestamp DESC, o.order_id ASC"
)) {
  $array = array();
  while ($row = $allOrders->fetch_assoc()) {
    $array[] = $row;
  }
  echo json_encode($array);
} else {
  echo "ERROR";
}
$allOrders->close();
include("../fragments/connection-end.php");
?>
