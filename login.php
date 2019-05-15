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
    <form class="form-signin">
      <fieldset>
        <legend class="form-signin-heading">Login</legend>
        <label for="logEmail" class="sr-only">Email:</label>
        <input type="email" class="form-control" autocomplete="on" placeholder="Email.." required autofocus id="loginEmail"/>
        <label for="logPassword" class="sr-only">Password:</label>
        <input type="password" class="form-control" placeholder="Password.." required id="loginPassword"/>
        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Login"/>
      </fieldset>
      <p class="text-muted small mt-1">Don't have an account? Sign in <a href="signup.php">here</a></p>
      <p id="result" class="mt-3"></p>
    </form>
  </div>

  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
$(function() {
  $("form").on('submit', function(e) {
    // prevent the submit button from refreshing the page
    e.preventDefault()
    $.post("/ajax/login_submitted.php", {
      email: $("#loginEmail").val(),
      password: $("#loginPassword").val()
    }).done(function(response) {
      if (response === "LOGIN_SUCCESS_CLIENT") {
        $("input .submit").prop('disabled', true)
        $("#result").text("Login successful. Redirecting shortly...")
        $("#result").fadeOut()
        $("#result").fadeIn()
        setTimeout(function() {
          window.location.href = "home_clients.php"
        }, 2500)
      } else if (response === "LOGIN_SUCCESS_PROVIDER") {
        $("input .submit").prop('disabled', true)
        $("#result").text("Login successful. Redirecting shortly...")
        $("#result").fadeOut()
        $("#result").fadeIn()
        setTimeout(function() {
          window.location.href = "home_providers.php"
        }, 2500)
      } else {
        $("#result").fadeOut()
        $("#result").text(response)
        $("#result").fadeIn()
      }
    })
  })
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
