<?php
include("../fragments/connection-begin.php");
session_start();

if (!ISSET($_SESSION['last_order_update_timestamp'])) {
  $_SESSION['last_order_update_timestamp'] = date("Y-m-d H:i:s", mktime());
  echo "EMPTY";
} else {
  if ($orderUpdate = $conn->query(
    "SELECT co.client_id, o.order_id, o.last_status_update, o.order_address, o.status_id, s.status_name
    FROM `order` o
    LEFT JOIN `client_order` co
    ON o.order_id = co.order_id
    LEFT JOIN `status` s
    ON o.status_id = s.status_id
    WHERE co.client_id = '".$_SESSION['user_id']."'
    AND '".$_SESSION['last_order_update_timestamp']."' < o.last_status_update;"
  )) {
    $_SESSION['last_order_update_timestamp'] = date("Y-m-d H:i:s", mktime());
    $array = array();
    while ($row = $orderUpdate->fetch_assoc()) {
      $array[] = $row;
    }
    if ($array == []) {
      echo "EMPTY";
    } else {
      echo json_encode($array);
    }
  } else {
    echo "ERROR";
  }
}
include("../fragments/connection-end.php");
?>
