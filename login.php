<?php
  if (/*$_SERVER["REQUEST_METHOD"] == "POST" && */isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $servername = "localhost";
    $username = "root";
    $dbpassword="";
    $db = "uni_web_prod";
    $conn = new mysqli($servername, $username,$dbpassword,$db);
    echo "Testing connection... ";
    if($conn->connect_error) {
      header('Location: login_failed.php');
      die("Connection failed: ".$conn->connect_error);
    }
    echo "Connection successful. ";
    if ($result = $conn->query("SELECT * FROM client WHERE client_email = '$email' AND client_password = '$password'")) {
      session_start();
      $row = mysqli_fetch_row($result);
      $_SESSION['user_id'] = $row[0];
      $_SESSION['logged'] = TRUE;
      $_SESSION['client_name'] = $row[3];
      header('Location: home_clients.php');
      exit;
    } else {
      echo "DEBUG: Bad credentials. Mail: $email. Password: $password.";
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="styles\style.css"/>
</head>

<body>
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

  <footer class="footer">
    <div class="container">
      <p class="text-muted">Dummy Copyrights</p>
    </div>
  </footer>
</body>

</html>
