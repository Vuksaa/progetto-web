<?php
session_start();
include("../fragments/connection-begin.php");
if ($statement=$conn->prepare("
  INSERT INTO client_provider(client_provider.client_id, client_provider.provider_id)
  VALUES (?, ?)
  ")) {
    if($statement->bind_param('ii', $_SESSION['user_id'], $_POST['providerId'])) {
      if($statement->execute()) {
        echo "SUCCESS";
      } else {
        echo "ERROR: Execution failed: ".$statement->error;
      }
    } else {
      echo "ERROR: Bind failed.";
    }
} else {
  echo "ERROR: Prepare statement failed.";
}
$statement->close();
include("../fragments/connection-end.php");
?>
