<?php
include("../fragments/connection-begin.php");
session_start();
if (!isset($_POST['order_id']) || !isset($_POST['new_state'])) {
  echo "ERROR INVALID DATA";
  include("../fragments/connection-end.php");
  return;
}
if ($statement = $conn->prepare(
  "UPDATE `order`
  SET `status_id` = ?
  WHERE `order_id` = ?;")) {
  $statement->bind_param("ii", $_POST['new_state'], $_POST['order_id']);
  $statement->execute();
  $statement->close();
  echo "SUCCESS";
} else {
  echo "ERROR: ".$conn->error;
}
include("../fragments/connection-end.php");
?>
