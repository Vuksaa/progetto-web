<!DOCTYPE html>
<html lang="it">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <?php include("fragments/navbar-empty.php"); ?>

  <div class="container pt-5 text-center">
    <img src="res/logo_l.png" class="logo" width="300" height="300" alt="Logo">
    <form class="form-signin needs-validation" novalidate>
      <fieldset>
        <legend class="form-signin-heading display-4 pb-4">Accedi</legend>
        <div class="form-group">
          <label for="logEmail" class="sr-only">Email:</label>
          <input type="email" class="form-control" autocomplete="username" placeholder="Email.." required autofocus id="loginEmail" maxlength="20" />
          <div class="valid-feedback">
            Email valida!
          </div>
          <div class="invalid-feedback">
            Fornire un'email valida! (esempio@esempio.es) [massimo 20 caratteri]
          </div>
        </div>
        <div class="form-group">
          <label for="logPassword" class="sr-only">Password:</label>
          <input type="password" class="form-control" autocomplete="current-password" placeholder="Password.." required id="loginPassword" maxlength="20" />
          <div class="valid-feedback">
            Password valida!
          </div>
          <div class="invalid-feedback">
            Fornire una password valida! [massimo 20 caratteri]
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" value="Login">
          Accedi
        </button>
      </fieldset>
      <p class="text-muted small mt-1">Non hai un account? Registrati <a href="signup.php">qui</a></p>
      <div class="mt-3 d-none" id="alertDiv">
        <div class="alert alert-success" role="alert">
          Accesso avvenuto con successo. Verrai reindirizzato a breve...
        </div>
        <div class="alert alert-danger" role="alert">

        </div>
      </div>
    </form>
  </div>

  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
  $(function() {
    // Hides the alert
    $(".alert").hide();
    $("#alertDiv").removeClass("d-none");
    var form = $("form");
    form.on('submit', function(event) {
      // prevent the submit button from refreshing the page
      event.preventDefault();
      if (form[0].checkValidity() === false) {
        event.stopPropagation();
      } else {
        //  Calls the login_submitted script and sets the alert
        $.post("ajax/login_submitted.php", {
          email: $("#loginEmail").val(),
          password: $("#loginPassword").val()
        }).done(function(response) {
          if (response.indexOf("LOGIN_SUCCESS") != -1) {
            $("input.submit").prop('disabled', true);
            $(".alert.alert-danger").fadeOut();
            $(".alert.alert-success").fadeOut();
            $(".alert.alert-success").fadeIn();
            if (response === "LOGIN_SUCCESS_CLIENT") {
              setTimeout(function() {
                window.location.href = "home_clients.php";
              }, 2500)
            } else if (response === "LOGIN_SUCCESS_PROVIDER") {
              setTimeout(function() {
                window.location.href = "home_providers.php";
              }, 2500)
            }
          } else {
            $(".alert.alert-success").fadeOut();
            $(".alert.alert-danger").fadeOut();
            $(".alert.alert-danger").text(response);
            $(".alert.alert-danger").fadeIn();
          }
        });
      }
      form.addClass('was-validated');
    });
  });
</script>
<?php include("fragments/connection-end.php"); ?>

</html>
