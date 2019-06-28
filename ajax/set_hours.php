<?php
include("../fragments/connection-begin.php");
session_start();
if (!isset($_POST['opening']) || !strtotime($_POST['opening']) || !isset($_POST['closing']) || !strtotime($_POST['closing'])) {
  echo "ERROR INVALID DATA";
  include("../fragments/connection-end.php");
  return;
}
if ($statement = $conn->prepare(
  "UPDATE `provider`
  SET `opening_hours` = ?, `closing_hours` = ?
  WHERE `provider_id` = '".$_SESSION['user_id']."'")) {
  $opening = date("H:i", strtotime($_POST['opening']));
  $closing = date("H:i", strtotime($_POST['closing']));
  $statement->bind_param("ss", $opening, $closing);
  $statement->execute();
  $statement->close();
  $statement = $conn->query(
    "SELECT TIME_FORMAT(opening_hours, '%H:%i') AS 'opening_hours', TIME_FORMAT(closing_hours, '%H:%i') AS 'closing_hours'
    FROM provider
    WHERE provider_id = '".$_SESSION['user_id']."';");
  $res = $statement->fetch_assoc();
  $_SESSION['opening_hours'] = $res['opening_hours'];
  $_SESSION['closing_hours'] = $res['closing_hours'];
  $statement->close();
  echo "SUCCESS";
} else {
  echo "ERROR: ".$conn->error;
}
include("../fragments/connection-end.php");
?>
