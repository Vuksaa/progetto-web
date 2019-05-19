<?php
session_start();
include("../fragments/connection-begin.php");
if ($statement=$conn->prepare("
  DELETE FROM client_provider
  WHERE client_provider.client_id = ? AND client_provider.provider_id = ?
  ")) {
    if($statement->bind_param('ii', $_SESSION['user_id'], $_POST['providerId'])) {
      if($statement->execute()) {
        echo "SUCCESS";
      } else {
        echo "Execution failed: ".$statement->error;
      }
    } else {
      echo "Bind failed.";
    }
} else {
  echo "Prepare statement failed.";
}
$statement->close();
include("../fragments/connection-end.php");
?>
