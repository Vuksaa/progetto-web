<?php
session_start();
include("../fragments/connection-begin.php");
if(!($statement=$conn->prepare("CALL provider_category_add(?,?)"))){
  echo "ERROR Prepare failed.";
}
if(!($statement->bind_param('ii', $_SESSION['user_id'], $_POST['category']))) {
  echo "ERROR Bind failed.";
}
if(!($statement->execute())){
  echo "ERROR Execution failed: ".$statement->error;
}
echo "OK";
$statement->close();
include("../fragments/connection-end.php");
?>
