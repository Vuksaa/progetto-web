<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <?php include("fragments/navbar-empty.php"); ?>

  <form class="form-signin container pt-5">
    <fieldset>
      <legend class="form-signin-heading">Login</legend>
      <div class="form-group">
        <label for="logEmail" class="sr-only">Email:</label>
        <input type="email" class="form-control" autocomplete="username" placeholder="Email.." required autofocus id="loginEmail" />
      </div>
      <div class="form-group">
        <label for="logPassword" class="sr-only">Password:</label>
        <input type="password" class="form-control" autocomplete="current-password" placeholder="Password.." required id="loginPassword" />
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" value="Login">
        Login
      </button>
    </fieldset>
    <p class="text-muted small mt-1">Don't have an account? Sign in <a href="signup.php">here</a></p>
    <div class="mt-3 d-none" id="alertDiv">
      <div class="alert alert-success" role="alert">
        Login successful. Redirecting shortly...
      </div>
      <div class="alert alert-danger" role="alert">

      </div>
    </div>
  </form>

  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
  $(function() {
    // Hides the alert
    $(".alert").hide();
    $("#alertDiv").removeClass("d-none");
    // Calls the login_submitted script and sets the alert
    $("form").on('submit', function(e) {
      // prevent the submit button from refreshing the page
      e.preventDefault();
      $.post("ajax/login_submitted.php", {
        email: $("#loginEmail").val(),
        password: $("#loginPassword").val()
      }).done(function(response) {
        if (response.indexOf("LOGIN_SUCCESS") != -1) {
          $("input.submit").prop('disabled', true)
          $(".alert.alert-danger").fadeOut()
          $(".alert.alert-success").fadeOut()
          $(".alert.alert-success").fadeIn()
          if (response === "LOGIN_SUCCESS_CLIENT") {
            setTimeout(function() {
              window.location.href = "home_clients.php"
            }, 2500)
          } else if (response === "LOGIN_SUCCESS_PROVIDER") {
            setTimeout(function() {
              window.location.href = "home_providers.php"
            }, 2500)
          }
        } else {
          $(".alert.alert-success").fadeOut();
          $(".alert.alert-danger").fadeOut();
          $(".alert.alert-danger").text(response);
          $(".alert.alert-danger").fadeIn();
        }
      })
    })
  })
</script>
<?php include("fragments/connection-end.php"); ?>

</html>
