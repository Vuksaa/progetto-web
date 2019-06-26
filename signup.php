<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <?php include("fragments/navbar-empty.php"); ?>
  <form class="form-signin container pt-5 needs-validation" novalidate>
    <fieldset>
      <legend class="form-signin-heading">Signup</legend>
      <div class="form-group">
        <label for="signEmail" class="sr-only">Email:</label>
        <input type="email" class="form-control" name="email" autocomplete="username" placeholder="Email.." required autofocus id="signEmail" />
        <div class="valid-feedback">
          Valid Email!
        </div>
        <div class="invalid-feedback">
          Please provide a valid Email! (example@example.exm)
        </div>
      </div>
      <div class="form-group">
        <label for="signPassword" class="sr-only">Password:</label>
        <input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="Password.." required id="signPassword" />
        <div class="valid-feedback">
          Valid Password!
        </div>
        <div class="invalid-feedback">
          Please provide a valid Password!
        </div>
      </div>
      <div class="form-group">
        <label for="signConfirmPassword" class="sr-only">Confirm Password:</label>
        <input type="password" class="form-control" name="confirmPassword" autocomplete="new-password" placeholder="Confirm password.." required id="signConfirmPassword" />
        <div class="valid-feedback">
          Valid Confirmation Password!
        </div>
        <div class="invalid-feedback">
          Please type the Password again correctly!
        </div>
      </div>
      <div class="form-group">
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="userType" value="client" checked id="signClient" />
          <label for="signClient" class="custom-control-label">Client</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" class="custom-control-input" name="userType" value="provider" id="signProvider" />
          <label for="signProvider" class="custom-control-label">Provider</label>
        </div>
      </div>
      <div class="form-group" id="clientName">
        <label for="signName" class="sr-only">Client Name:</label>
        <input type="text" class="form-control" name="name" autocomplete="on" placeholder="Name.." required id="signName" />
        <div class="valid-feedback">
          Valid Name!
        </div>
        <div class="invalid-feedback">
          Please provide a name!
        </div>
      </div>
      <div class="form-group" id="clientSurname">
        <label for="signSurname" class="sr-only">Client Surname:</label>
        <input type="text" class="form-control" name="surname" autocomplete="on" placeholder="Surname.." required id="signSurname" />
        <div class="valid-feedback">
          Valid Surname!
        </div>
        <div class="invalid-feedback">
          Please provide a Surname!
        </div>
      </div>
      <div class="form-group" hidden id="providerName">
        <label for="signPName" class="sr-only">Provider Name:</label>
        <input type="text" class="form-control" name="pname" autocomplete="on" placeholder="Name.." id="signPName" />
        <div class="valid-feedback">
          Valid Name!
        </div>
        <div class="invalid-feedback">
          Please provide a Name!
        </div>
      </div>
      <div class="form-group" hidden id="providerAddress">
        <label for="signPAddress" class="sr-only">Provider Address:</label>
        <input type="text" class="form-control" name="paddress" autocomplete="on" placeholder="Address.." id="signPAddress" />
        <div class="valid-feedback">
          Valid Address!
        </div>
        <div class="invalid-feedback">
          Please provide an Address!
        </div>
      </div>
      <div class="form-group" hidden id="providerType">
        <label for="signPType" class="sr-only">Provider Type:</label>
        <input type="number" class="form-control" name="typeId" autocomplete="on" placeholder="Type id.." id="signPType" />
        <div class="valid-feedback">
          Valid Type!
        </div>
        <div class="invalid-feedback">
          Please choose a Type!
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" value="Signup">
        Signup
      </button>
    </fieldset>
    <p class="text-muted small mt-1">Already have an account? Sign in <a href="login.php">here</a></p>
    <div class="mt-3 d-none" id="alertDiv">
      <div class="alert alert-success" role="alert">
        Signup successful. Redirecting shortly to login...
      </div>
      <div class="alert alert-danger" role="alert">

      </div>
    </div>
  </form>
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
        vconfPassword[0].setCustomValidity("Passwords don't match!");
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