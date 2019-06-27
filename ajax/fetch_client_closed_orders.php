<?php
include("../fragments/connection-begin.php");
session_start();
if ($orders = $conn->query(
  "SELECT o.order_id, pr.provider_name, pr.provider_id, o.rejection_reason, o.order_address, p.product_name, s.status_name, s.status_id, po.notes, po.quantity, o.creation_timestamp
  FROM uni_web_prod.order o
  JOIN product_order po
  ON o.order_id = po.order_id
  JOIN product p
  ON po.product_id = p.product_id
  JOIN status s
  ON o.status_id = s.status_id
  JOIN client_order co
  ON o.order_id = co.order_id
  JOIN provider pr
  ON p.provider_id = pr.provider_id
  WHERE co.client_id = '".$_SESSION['user_id']."'
  AND s.status_id != 1 AND s.status_id != 4;"
)) {
  $array = array();
  while ($row = $orders->fetch_assoc()) {
    $array[] = $row;
  }
  if ($array == []) {
    echo "EMPTY";
  } else {
    echo json_encode($array);
  }
  $orders->close();
} else {
  echo "ERROR";
}
include("../fragments/connection-end.php");
?>
