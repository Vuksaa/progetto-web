<?php
session_start();
include("../fragments/connection-begin.php");
if(!($statement=$conn->prepare("CALL product_disable(?)"))) {
  echo "ERROR: Prepare failed.";
}
if(!($statement->bind_param('i',$_POST['product']))) {
  echo "ERROR: Bind failed.";
}
if(!($statement->execute())) {
  echo "ERROR: Execution failed: ".$statement->error;
}
echo "SUCCESS";
$statement->close();
include("../fragments/connection-end.php");
?>
