<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <?php include("fragments/navbar-empty.php"); ?>

  <form action="ajax/signup_submitted.php" method="post" name="signup_form" class="form-signin container pt-5">
    <fieldset>
      <legend class="form-signin-heading">Signup</legend>
      <div class="form-group">
        <label for="signEmail" class="sr-only">Email:</label>
        <input type="email" class="form-control" name="email" autocomplete="on" placeholder="Email.." required id="signEmail" />
      </div>
      <div class="form-group">
        <label for="signPassword" class="sr-only">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Password.." required id="signPassword" />
      </div>
      <div class="form-group">
        <label for="signConfirmPassword" class="sr-only">Confirm Password:</label>
        <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password.." required id="signConfirmPassword" />
      </div>
      <div class="form-check form-check-inline">
        <label for="signClient" class="form-check-label">
          <input type="radio" class="form-check-input" name="userType" value="client" checked id="signClient" />Client
        </label>
        <div class="form-check form-check-inline">
          <label for="signProvider" class="form-check-label">
            <input type="radio" class="form-check-input" name="userType" value="provider" id="signProvider" />Provider
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="signName" class="sr-only">Name:</label>
        <input type="text" class="form-control" name="name" autocomplete="on" placeholder="Name.." required id="signName" />
      </div>
      <div class="form-group">
        <label for="signSurname" class="sr-only">Surname:</label>
        <input type="text" class="form-control" name="surname" autocomplete="on" placeholder="Surname.." required id="signSurname" />
      </div>
      <div class="form-group">
        <label for="signPName" class="sr-only">PName:</label>
        <input type="text" class="form-control" name="pname" autocomplete="on" placeholder="Name.." required id="signPName" hidden />
      </div>
      <div class="form-group">
        <label for="signPAddress" class="sr-only">PAddress:</label>
        <input type="text" class="form-control" name="paddress" autocomplete="on" placeholder="Address.." required id="signPAddress" hidden />
      </div>
      <div class="form-group">
        <label for="signPType" class="sr-only">PType:</label>
        <input type="number" class="form-control" name="typeId" autocomplete="on" placeholder="Type id.." required id="signPType" hidden />
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" value="userSignup">
        Signup
      </button>
    </fieldset>
    <p class="text-muted small mt-1">Already have an account? Sign in <a href="login.php">here</a></p>
  </form>
  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
  $(function() {
    // Shows/hides form inputs depending on user type selected
    $('[type=radio][name=userType]').change(function() {
      var cName = $("#signName");
      var cSurname = $("#signSurname");
      var pName = $("#signPName");
      var pAddress = $("#signPAddress");
      var pType = $("#signPType");
      if (this.value === 'client') {
        cName.prop("hidden", false);
        cSurname.prop("hidden", false);
        pName.prop("hidden", true);
        pAddress.prop("hidden", true);
        pType.prop("hidden", true);
        cName.prop("required", true);
        cSurname.prop("required", true);
        pName.prop("required", false);
        pAddress.prop("required", false);
        pType.prop("required", false);
      } else if (this.value === 'provider') {
        cName.prop("hidden", true);
        cSurname.prop("hidden", true);
        pName.prop("hidden", false);
        pAddress.prop("hidden", false);
        pType.prop("hidden", false);
        cName.prop("required", false);
        cSurname.prop("required", false);
        pName.prop("required", true);
        pAddress.prop("required", true);
        pType.prop("required", true);
      }
    });
  })
</script>
<?php include("fragments/connection-end.php"); ?>

</html>