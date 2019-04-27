<?php
  if (/*$_SERVER["REQUEST_METHOD"] == "POST" && */isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $servername = "localhost";
    $username = "root";
    $dbpassword="";
    $db = "uni_web_prod";
    $uId=0;
    $uName="";
    $conn = new mysqli($servername, $username,$dbpassword,$db);
    echo "Testing connection... ";
    if($conn->connect_error) {
      header('Location: login_failed.php');
      die("Connection failed: ".$conn->connect_error);
    }
    echo "Connection successful. ";
    if(!($statement=$conn->prepare("SELECT client_id,client_name FROM client WHERE client_email = ? AND client_password = ? LIMIT 1"))){
      echo "Prepare failed.";
    }
    if(!($statement->bind_param('ss',$email,$password))) {
      echo "Bind failed";
    }
    if (!($statement->execute())) {
      echo "Execution failed.";
    }
    echo " Executed.";
    $statement->store_result();
    $statement->bind_result($uId,$uName);
    $statement->fetch();
    if($statement->num_rows > 0) {
      session_start();
      $_SESSION['user_id'] = $uId;
      $_SESSION['logged'] = TRUE;
      $_SESSION['user_name'] = $uName;
      $_SESSION['user_type'] = "client";
      echo " Test id:".$uId." name:".$_SESSION['user_name'];
      $statement->close();
      header('Location: home_clients.php');
      exit;
    } else {
        if(!($statement=$conn->prepare("SELECT provider_id,provider_name FROM provider WHERE provider_email = ? AND provider_password = ? LIMIT 1"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('ss',$email,$password))) {
          echo "Bind failed";
        }
        if (!($statement->execute())) {
          echo "Execution failed.";
        }
        echo " Executed.";
        $statement->store_result();
        $statement->bind_result($uId,$uName);
        $statement->fetch();
        if($statement->num_rows > 0) {
          session_start();
          $_SESSION['user_id'] = $uId;
          $_SESSION['logged'] = TRUE;
          $_SESSION['user_name'] = $uName;
          $_SESSION['user_type'] = "provider";
          echo " Test id:".$uId." name:".$_SESSION['user_name'];
          $statement->close();
          header('Location: home_providers.php');
          exit;
      } else {
        echo "DEBUG: Bad credentials. Mail: $email. Password: $password.";
      }
  }
}
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <!-- TODO: use an include for the navbar even without buttons -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="#">
      <img src="res/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Project
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
    </div>
  </nav>

  <div class="pos-f-t">
    <div class="collapse" id="navbarToggleExternalContent">
      <div class="bg-dark p-4">
        <h1 class="text-white h4">Menu</h1>
        <ul>
          <li><a href="signin.html">Sign-in</a></li>
          <li><a href="homepage.html">Home</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container pt-5">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="login_form" class="form-signin">
      <fieldset>
        <legend class="form-signin-heading">Login</legend>
        <label for="logEmail" class="sr-only">Email:</label>
        <input type="email" class="form-control" name="email" autocomplete="on" placeholder="Email.." required autofocus id="logEmail" />
        <label for="logPassword" class="sr-only">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Password.." required id="logPassword" />
        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Login" onclick="" />
      </fieldset>
      <p class="text-muted small">Don't have an account? Sign in <a href="signup.html">here</a></p>
    </form>
  </div>

  <?php include("fragments/footer.php"); ?>
</body>

</html>
