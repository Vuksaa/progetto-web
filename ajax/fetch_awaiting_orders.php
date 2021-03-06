<?php
include("../fragments/connection-begin.php");
session_start();
if (!ISSET($_SESSION['last_awaiting_orders_fetch_timestamp'])) {
  $_SESSION['last_awaiting_orders_fetch_timestamp'] = date("Y-m-d H:i:s", mktime());
  echo "EMPTY";
} else {
  $now = date("Y-m-d H:i:s", mktime());
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
    AND '".$_SESSION['last_awaiting_orders_fetch_timestamp']."' <= o.creation_timestamp
    AND o.creation_timestamp < '".$now."';"
  )) {
    $_SESSION['last_awaiting_orders_fetch_timestamp'] = $now;
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
}
include("../fragments/connection-end.php");
?>
