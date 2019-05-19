<?php
$email = $_POST['email'];
$password = $_POST['password'];
$uId=0;
$uName="";
include("../fragments/connection-begin.php");
$statement=$conn->prepare("
  SELECT client_id, client_name
  FROM client
  WHERE client_email = ?
  AND client_password = ?
  LIMIT 1
");
$statement->bind_param('ss',$email,$password);
$statement->execute();
$statement->store_result();
$statement->bind_result($uId,$uName);
$statement->fetch();
if ($statement->num_rows > 0) {
  session_start();
  $_SESSION['user_id'] = $uId;
  $_SESSION['logged'] = TRUE;
  $_SESSION['user_name'] = $uName;
  $_SESSION['user_type'] = "client";
  $statement->close();
  echo "LOGIN_SUCCESS_CLIENT";
} else {
    $statement=$conn->prepare("
      SELECT provider_id, provider_name
      FROM provider
      WHERE provider_email = ?
      AND provider_password = ?
      LIMIT 1
    ");
    $statement->bind_param('ss',$email,$password);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($uId,$uName);
    $statement->fetch();
    if($statement->num_rows > 0) {
      session_start();
      $_SESSION['user_id'] = $uId;
      $_SESSION['logged'] = TRUE;
      $_SESSION['user_name'] = $uName;
      $_SESSION['user_type'] = "provider";
      $statement->close();
      echo "LOGIN_SUCCESS_PROVIDER";
  } else {
    echo "Login failed. Invalid credentials.";
  }
}
include("../fragments/connection-end.php");
?>
