<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
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

  <form action="ajax/signup_submitted.php" method="post" name="signup_form" class="form-signin container pt-5" accept-charset="UTF-8">
    <fieldset>
      <legend class="form-signin-heading">Signup</legend>
      <label for="signEmail" class="sr-only">Email:</label>
      <input type="email" class="form-control" name="email" autocomplete="on" placeholder="Email.." required id="signEmail" />
      <label for="signPassword" class="sr-only">Password:</label>
      <input type="password" class="form-control" name="password" placeholder="Password.." required id="signPassword" />
      <label for="signConfirmPassword" class="sr-only">Confirm Password:</label>
      <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm password.." required id="signConfirmPassword" />
      <label for="signName" class="sr-only">Name:</label>
      <input type="text" class="form-control" name="name" autocomplete="on" placeholder="client Name.." required id="signName" />
      <label for="signSurname" class="sr-only">Surname:</label>
      <input type="text" class="form-control" name="surname" autocomplete="on" placeholder="client Surname.." required id="signSurname" />
      <label for="signPName" class="sr-only">PName:</label>
      <input type="text" class="form-control" name="pname" autocomplete="on" placeholder="provider name.." required id="signPName" />
      <label for="signPAddress" class="sr-only">PAddress:</label>
      <input type="text" class="form-control" name="paddress" autocomplete="on" placeholder="provider address.." required id="signPAddress" />
      <label for="signPType" class="sr-only">PType:</label>
      <input type="number" class="form-control" name="typeId" autocomplete="on" placeholder="provider type id.." required id="signPType" />
      <div class="form-check form-check-inline">
        <label for="signClient" class="form-check-label">
          <input type="radio" class="form-check-input" name="userType" value="client" checked id="signClient" />Client
        </label>
      </div>
      <div class="form-check form-check-inline">
        <label for="signProvider" class="form-check-label">
          <input type="radio" class="form-check-input" name="userType" value="provider" id="signProvider" />Provider
        </label>
      </div>
      <button type="submit" class="btn btn-primary btn-lg btn-block" value="userSignup">
        Signup
      </button>
    </fieldset>
  </form>

  <?php include("fragments/footer.php"); ?>
</body>

</html>
