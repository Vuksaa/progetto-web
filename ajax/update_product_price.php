<?php
include("../fragments/connection-begin.php");
session_start();
if ($statement = $conn->prepare(
  "UPDATE product
  SET product_price = ?
  WHERE product_id = ?;")) {
  $statement->bind_param("di", $_POST['price'], $_POST['id']);
  $statement->execute();
  $statement->close();
  echo "SUCCESS";
} else {
  echo "ERROR: ".$conn->error;
}
include("../fragments/connection-end.php");
?>
