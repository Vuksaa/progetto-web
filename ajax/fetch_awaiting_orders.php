<?php
// this php script does not take into account timezones. $_POST['timestamp'] is used as if it were of the same timezone as the DB's timezone.
$timestamp = date("Y-m-d H:i:s", $_POST['timestamp']);
include("../fragments/connection-begin.php");
session_start();
// only select the orders that were created in the last week
if ($awaitingOrders = $conn->query(
  "SELECT o.order_id, c.client_name, o.order_address, p.product_name, s.status_name, s.status_id, po.notes, po.quantity, o.creation_timestamp
  FROM uni_web_prod.order o
  JOIN product_order po
  ON o.order_id = po.order_id
  JOIN product p
  ON po.product_id = p.product_id
  JOIN status s
  ON o.status_id = s.status_id
  JOIN client_order co
  ON o.order_id = co.order_id
  JOIN client c
  ON co.client_id = c.client_id
  WHERE p.provider_id = '".$_SESSION['user_id']."'
  AND o.status_id = 4
  AND '".$timestamp."' < o.creation_timestamp"
)) {
  $array = array();
  while ($row = $awaitingOrders->fetch_assoc()) {
    $array[] = $row;
  }
  if ($array == []) {
    echo "EMPTY";
  } else {
    echo json_encode($array);
  }
  $awaitingOrders->close();
} else {
  echo "ERROR";
}
include("../fragments/connection-end.php");
?>
