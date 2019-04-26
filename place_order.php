<?php
  session_start();
  if (!isset($_SESSION['logged']) || $_SESSION['logged'] == FALSE) {
    header('Location: login.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="home_clients.php">
      <img src="res/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Project
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="home_clients.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile_clients.php"><i class="fas fa-user"></i> Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders_clients.php"><i class="fas fa-book"></i> Orders</a>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <div class="navbar-text">Welcome, <?php echo $_SESSION['user_name']; ?>. Bon appétit!</div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- <div class="container p-5">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="providerSelection" class="form">
      <fieldset>
        <label for="providerId" class="sr-only">Email:</label>
        <input type="text" class="form-control" name="providerId" autocomplete="off" placeholder="<?php echo $_POST["providerId"] ?>" required autofocus id="providerId" />
        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Confirm" onclick="" />
      </fieldset>
      <p class="text-muted small">Current id: <?php echo $_POST["providerId"] ?></p>
    </form>
  </div> -->
  <div class="container pt-4 pb-4">
    <h3 class="pb-2">Place order</h3>
    <div class="card">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <h5 class="card-title">Menu</h5>
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <div class="card">
            <!-- maybe let providers add images for their products? <img class="card-img-top" src="..." alt="Card image cap"> -->
            <div class="card-body" id="listedProductIDCard">
              <h5 class="card-title">Product name</h5>
              <p class="card-text font-weight-light">Ingredient 1, Ingredient 2, Ingredient 3</p>
              <form class="form-group row">
                <label for="productIDQuantity" class="col-sm-2 col-form-label">Quantity</label>
                <input type="number" class="form-control col-sm-1" id="productIDQuantity" placeholder="Quantity" value="1" required>
              </form>
              <form class="form-group row">
                <label for="productIDNotes" class="col-sm-2 col-form-label">Notes</label>
                <input type="text" class="form-control col-sm-5" id="productIDNotes" placeholder="Notes">
              </form>
              <a href="#" class="btn btn-primary far fa-plus-square"></a>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <h5 class="card-title">Order review</h5>
          <div class="card">
            <div class="card-body" id="orderedProductIDCard">
              <h5 class="card-title">Product name</h5>
              <p class="card-text font-weight-light">Ingredient 1, Ingredient 2, Ingredient 3</p>
              <form class="form-group row">
                <label for="productIDQuantity" class="col-form-label col-sm-2">Quantity</label>
                <input type="number" class="form-control col-sm-1" id="productIDQuantity" placeholder="Quantity" value="1" required>
              </form>
              <form class="form-group row">
                <label for="productIDNotes" class="col-form-label col-sm-2">Notes</label>
                <input type="text" class="form-control col-sm-5" id="productIDNotes" placeholder="Notes">
              </form>
              <a href="#" class="btn btn-primary far fa-minus-square"></a>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <h5 class="card-title">Address and confirmation</h5>
            <form class="pt-2">
              <div class="form-group col-md-4">
                <div class="form-check custom-radio">
                  <input class="form-check-input" type="radio" id="radioSelectAddress" name="addressRadio" checked>
                  <label class="form-check-label" for="radioSelectAddress">Select address</label>
                </div>
                <div class="form-check custom-radio">
                  <input class="form-check-input" type="radio" id="radioEnterAddress" name="addressRadio">
                  <label class="form-check-label" for="radioEnterAddress">Enter address</label>
                </div>
              </div>
              <div class="form-group col-md-4 pt-2" id="formSelectAddress">
                <select class="custom-select" required>
                  <option value="">Select address</option>
                  <option value="1">Address 1</option>
                  <option value="2">Address 2</option>
                  <option value="3">Address 3</option>
                </select>
              </div>
              <!-- created with the d-none class so that it doesn't briefly show up before the DOM is ready -->
              <div class="form-group d-none" id="formEnterAddress">
                <div class="form-group row">
                  <label for="enteredAddress" class="col-form-label col-sm-1">Address</label>
                  <input type="text" class="form-control col-sm-4" id="enteredAddress" placeholder="Address" required>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="custom-control-input" value="" id="checkSaveAddress">
                  <label class="custom-control-label" for="checkSaveAddress">Save this address</label>
                </div>
                <div class="form-group row pt-1 d-none" id="formEnterAddressName">
                  <label for="enteredAddressName" class="col-form-label col-sm-1">Name</label>
                  <input type="text" class="form-control col-sm-2" id="enteredAddressName" placeholder="Name">
                </div>
              </div>
            <button type="button" id="btnComplete" class="btn btn-primary mt-4">Pay and order</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
  <footer class="footer">
    <div class="container">
      <p class="text-muted">Dummy Copyrights</p>
    </div>
  </footer>
</body>

<script type="text/javascript">
$(function() {
  // Hide "enter address" form, and add event handlers for hiding the appropriate form on the radiobuttons
  // We remove the class d-none from formEnterAddress so jquery can handle hiding/showing with its hide and show functions
  $("#formEnterAddress").hide()
  $("#formEnterAddress").removeClass("d-none")
  $("#radioEnterAddress").on('change', function(e) {
    $("#formEnterAddress").show()
    $("#formSelectAddress").hide()
  })
  $("#radioSelectAddress").on('change', function(e) {
    $("#formEnterAddress").hide()
    $("#formSelectAddress").show()
  })

  // validation
  $("#btnComplete").on('click', function(e) {
    if ($("#radioSelectAddress:checked").val() && $("#enteredAddress").val() === '') {
      alert("Must select an address!")
    }
  })

  // hide the field for entering the address name if the user doesn't wish to save it. it is hidden by default
  $("#formEnterAddressName").hide()
  $("#formEnterAddressName").removeClass("d-none")
  $("#checkSaveAddress").on('change', function(e) {
    if ($(this).is(":checked") == true) {
      $("#formEnterAddressName").show()
    } else {
      $("#formEnterAddressName").hide()
    }
  })
})
</script>

</html>
