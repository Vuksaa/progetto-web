<?php
$email = $_POST['email'];
$options = [
    'salt' => "thistringisforsalttest"
];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
$userType = $_POST['userType'];
include("../fragments/connection-begin.php");
if($userType==="client") {
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $statement=$conn->prepare("CALL client_add(?,?,?,?)");
  if(!($statement->bind_param('ssss',$email,$password,$name,$surname))) {
    echo "ERROR Bind failed.";
  }
  if(!($statement->execute())){
    echo "ERROR Execution failed: ".$statement->error;
  }
  echo "OK";
  $statement->close();
} else if($userType==="provider") {
  $name = $_POST['pname'];
  $address = $_POST['paddress'];
  $typeId = $_POST['typeId'];
  $statement=$conn->prepare("CALL provider_add(?,?,?,?,?)");
  if(!($statement->bind_param('ssssi',$name,$address,$email,$password,$typeId))) {
    echo "ERROR Bind failed.";
  }
  if(!($statement->execute())){
    echo "ERROR Execution failed: ".$statement->error;
  }
  echo "OK";
  $statement->close();
}

include("../fragments/connection-end.php");
?>
