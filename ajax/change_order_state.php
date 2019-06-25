<?php
include("../fragments/connection-begin.php");
session_start();
if (!isset($_POST['order_id']) || !isset($_POST['new_state']) || ($_POST['new_state'] == 2 && !isset($_POST['reason']))) {
  echo "ERROR INVALID DATA";
  include("../fragments/connection-end.php");
  return;
}
if ($statement = $conn->prepare(
  "UPDATE `order`
  SET `status_id` = ?, `last_status_update` = NOW()" . ($_POST['new_state'] == 2 ? ", `rejection_reason` = ?" : "") .
  " WHERE `order_id` = ?;")) {
  if ($_POST['new_state'] == 2) {
    $statement->bind_param("isi", $_POST['new_state'], $_POST['reason'], $_POST['order_id']);
  } else {
    $statement->bind_param("ii", $_POST['new_state'], $_POST['order_id']);
  }
  $statement->execute();
  $statement->close();
  echo "SUCCESS";
} else {
  echo "ERROR: ".$conn->error;
}
include("../fragments/connection-end.php");
?>
