<?php
$email = $_POST['email'];
$options = [
    'salt' => "thistringisforsalttest"
];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
$userType = $_POST['userType'];
include("../fragments/connection-begin.php");
$statement=$conn->prepare("select ue.user_email
                          from user_email ue
                          where ue.user_email=?");
if(!($statement->bind_param('s',$email))) {
  echo "ERROR Bind failed.";
}
if(!($statement->execute())){
  echo "ERROR Execution failed: ".$statement->error;
}
$statement->store_result();
if(!($statement->num_rows>0)){
  if($userType==="client") {
    $cName = $_POST['cName'];
    $cSurname = $_POST['cSurname'];
    $statement=$conn->prepare("CALL client_add(?,?,?,?)");
    if(!($statement->bind_param('ssss',$email,$password,$cName,$cSurname))) {
      echo "ERROR Bind failed.";
    }
    if(!($statement->execute())){
      echo "ERROR Execution failed: ".$statement->error;
    }
    echo "SIGNUP_SUCCESS";
    $statement->close();
  } else if($userType==="provider") {
    $pName = $_POST['pName'];
    $pAddress = $_POST['pAddress'];
    $pTypeId = $_POST['pTypeId'];
    $statement=$conn->prepare("CALL provider_add(?,?,?,?,?)");
    if(!($statement->bind_param('ssssi',$pName,$pAddress,$email,$password,$pTypeId))) {
      echo "ERROR Bind failed.";
    }
    if(!($statement->execute())){
      echo "ERROR Execution failed: ".$statement->error;
    }
    echo "SIGNUP_SUCCESS";
    $statement->close();
  }
} else {
  echo "Signup failed. Email already in use.";
}
$statement->close();
include("../fragments/connection-end.php");
?>
