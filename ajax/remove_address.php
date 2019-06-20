<?php
session_start();
include("../fragments/connection-begin.php");
if(!($statement=$conn->prepare("CALL address_remove(?)"))){
  echo "ERROR: Prepare failed.";
}
if(!($statement->bind_param('i',$_POST['address']))) {
  echo "ERROR: Bind failed.";
}
if(!($statement->execute())){
  echo "ERROR: Execution failed: ".$statement->error;
}
echo "OK";
$statement->close();
include("../fragments/connection-end.php");
?>
