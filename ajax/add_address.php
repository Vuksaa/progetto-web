<?php
session_start();
include("../fragments/connection-begin.php");
if(!($statement=$conn->prepare("CALL address_add(?,?,?, @insertedAddressId)"))){
  echo "Prepare failed.";
}
if(!($statement->bind_param('ssi',$_POST['name'],$_POST['info'],$_SESSION['user_id']))) {
  echo "Bind failed.";
}
if(!($statement->execute())){
  echo "Execution failed: ".$statement->error;
}
echo $statement->get_result()->fetch_assoc()['insertedAddressId'];
$statement->close();
include("../fragments/connection-end.php");
?>
