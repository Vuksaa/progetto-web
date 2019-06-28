<?php include("fragments/connection-begin.php"); ?>
<!DOCTYPE html>
<html lang="it">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <div class="container pt-5 text-center">
    <form class="form-signin col" novalidate>
      <fieldset>
        <legend class="form-signin-heading display-4">GoodFood</legend>
        <img src="res/logo_l.png" class="logo-l mb-4" width="300" height="300" alt="Logo">
        <div class="form-group">
          <label for="signEmail" class="sr-only">Email:</label>
          <input type="email" class="form-control" name="email" autocomplete="username" placeholder="Email.." required autofocus id="signEmail" maxlength="40" />
          <div class="valid-feedback">
            Email valida!
          </div>
          <div class="invalid-feedback">
            Fornire un'email valida! (esempio@esempio.es) [massimo 40 caratteri]
          </div>
        </div>
        <div class="form-group">
          <label for="signPassword" class="sr-only">Password:</label>
          <input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Password.." required id="signPassword" maxlength="20" />
          <div class="valid-feedback">
            Password valida!
          </div>
          <div class="invalid-feedback">
            Fornire una password valida! [massimo 20 caratteri]
          </div>
        </div>
        <div class="form-group">
          <label for="signConfirmPassword" class="sr-only">Ripeti Password:</label>
          <input type="password" class="form-control" name="confirmPassword" autocomplete="new-password" placeholder="Ripeti password.." required id="signConfirmPassword" maxlength="20"/>
          <div class="valid-feedback">
            Password ripetuta correttamente!
          </div>
          <div class="invalid-feedback">
            Ripetere la password correttamente!
          </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" name="userType" value="client" checked id="signClient" />
              <label for="signClient" class="custom-control-label">Cliente</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" class="custom-control-input" name="userType" value="provider" id="signProvider" />
              <label for="signProvider" class="custom-control-label">Fornitore</label>
            </div>
          </div>
          <div class="form-group" id="clientName">
            <label for="signName" class="sr-only">Nome cliente:</label>
            <input type="text" class="form-control" name="name" autocomplete="on" placeholder="Nome.." required id="signName" maxlength="20"/>
            <div class="valid-feedback">
              Nome valido!
            </div>
            <div class="invalid-feedback">
              Fornire un nome! [massimo 20 caratteri]
            </div>
          </div>
          <div class="form-group" id="clientSurname">
            <label for="signSurname" class="sr-only">Cognome cliente:</label>
            <input type="text" class="form-control" name="surname" autocomplete="on" placeholder="Cognome.." required id="signSurname" maxlength="20"/>
            <div class="valid-feedback">
              Cognome valido!
            </div>
            <div class="invalid-feedback">
              Fornire un cognome! [massimo 20 caratteri]
            </div>
          </div>
          <div class="form-group" hidden id="providerName">
            <label for="signPName" class="sr-only">Nome fornitore:</label>
            <input type="text" class="form-control" name="pname" autocomplete="on" placeholder="Nome.." id="signPName" maxlength="20"/>
            <div class="valid-feedback">
              Nome valido!
            </div>
            <div class="invalid-feedback">
              Fornire un nome! [massimo 20 caratteri]
            </div>
          </div>
          <div class="form-group" hidden id="providerAddress">
            <label for="signPAddress" class="sr-only">Indirizzo fornitore:</label>
            <input type="text" class="form-control" name="paddress" autocomplete="on" placeholder="Indirizzo.." id="signPAddress" maxlength="20" />
            <div class="valid-feedback">
              Indirizzo valido!
            </div>
            <div class="invalid-feedback">
              Fornire un indirizzo valido! [massimo 20 caratteri]
            </div>
          </div>
          <div class="form-group" hidden id="providerType">
            <select class="custom-select">
              <?php
              if ($provTypes = $conn->query("
              SELECT t.type_id,t.type_name
              FROM type t
              ")) {
              while ($provType = $provTypes->fetch_assoc()) {
                echo '<option value="'.$provType['type_id'].'">'.$provType['type_name'].'</option>';
              }
            }
            ?>
            </select>
            <div class="valid-feedback">
              Tipo valido!
            </div>
            <div class="invalid-feedback">
              Seleziona un tipo!
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-lg btn-block" value="Signup">
            Registrati
          </button>
      </fieldset>
      <p class="text-muted small mt-1">Hai gi&agrave; un account? Accedi <a href="login.php">qui</a></p>
      <div class="mt-3 d-none" id="alertDiv">
        <div class="alert alert-success" role="alert">
          Registrazione avvenuta con successo. Verrai reindirizzato a breve all'accesso...
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
    'use strict';
    // Hides the alert
    $(".alert").hide();
    $("#alertDiv").removeClass("d-none");
    var form = $("form");
    form.on('submit', function(event) {
      event.preventDefault();
      // Checks form's validity
      var vconfPassword = $("#signConfirmPassword");
      var vpassword = $("#signPassword").val();
      if (vconfPassword.val() !== vpassword) {
        event.stopPropagation();
        vconfPassword[0].setCustomValidity("Le password non coincidono!");
      } else {
        vconfPassword[0].setCustomValidity("");
      }
      if (form[0].checkValidity() === false) {
        event.stopPropagation();
      } else {
        //  Calls the signup_submitted script and sets the alert
        var vemail = $("#signEmail").val();
        var vuserType = $("[type=radio][name=userType]").val();
        var vcName = $("#signName").val();
        var vcSurname = $("#signSurname").val();
        var vpName = $("#signPName").val();
        var vpAddress = $("#signPAddress").val();
        var vpTypeId = $("#signPType").val();
        var data = {
          email: vemail,
          password: vpassword,
          userType: vuserType,
          cName: vcName,
          cSurname: vcSurname,
          pName: vpName,
          pAddress: vpAddress,
          pTypeId: vpTypeId
        };
        $.post("ajax/signup_submitted.php", data).done(function(response) {
          if (response.indexOf("SIGNUP_SUCCESS") != -1) {
            $("input.submit").prop('disabled', true);
            $(".alert.alert-danger").fadeOut();
            $(".alert.alert-success").fadeOut();
            $(".alert.alert-success").fadeIn();
            setTimeout(function() {
              window.location.href = "login.php"
            }, 2500)
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
    // Shows/hides form inputs depending on user type selected
    $('[type=radio][name=userType]').change(function() {
      var cName = $("#clientName");
      var cSurname = $("#clientSurname");
      var pName = $("#providerName");
      var pAddress = $("#providerAddress");
      var pType = $("#providerType");
      var icName = $("#signName");
      var icSurname = $("#signSurname");
      var ipName = $("#signPName");
      var ipAddress = $("#signPAddress");
      var ipType = $("#signPType");
      if (this.value === 'client') {
        cName.prop("hidden", false);
        cSurname.prop("hidden", false);
        pName.prop("hidden", true);
        pAddress.prop("hidden", true);
        pType.prop("hidden", true);
        icName.prop("required", true);
        icSurname.prop("required", true);
        ipName.prop("required", false);
        ipAddress.prop("required", false);
        ipType.prop("required", false);
      } else if (this.value === 'provider') {
        cName.prop("hidden", true);
        cSurname.prop("hidden", true);
        pName.prop("hidden", false);
        pAddress.prop("hidden", false);
        pType.prop("hidden", false);
        icName.prop("required", false);
        icSurname.prop("required", false);
        ipName.prop("required", true);
        ipAddress.prop("required", true);
        ipType.prop("required", true);
      }
    });
  });
</script>
<?php include("fragments/connection-end.php"); ?>

</html>
