<?php
session_start();
include("../fragments/connection-begin.php");
if(!($statement=$conn->prepare("CALL client_allergen_remove(?,?)"))){
  echo "ERROR: Prepare failed.";
}
if(!($statement->bind_param('ii',$_SESSION['user_id'],$_POST['allergen']))) {
  echo "ERROR: Bind failed.";
}
if(!($statement->execute())){
  echo "ERROR: Execution failed: ".$statement->error;
}
echo "OK";
$statement->close();
include("../fragments/connection-end.php");
?>
