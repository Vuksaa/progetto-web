<?php
  $db_login_servername = "localhost";
  $db_login_username = "root";
  $db_login_password="";
  $db_login_dbname = "uni_web_prod";
  $conn = new mysqli($db_login_servername, $db_login_username, $db_login_password, $db_login_dbname);
  if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
  }
?>
