<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "provider") {
    header('Location: profile_providers.php');
    exit();
  }
?>
<?php include("fragments/connection-begin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <?php include("fragments/navbar.php"); ?>

  <div class="container">

    <div class="card main-card">
      <h1 class="mb-0 form-group form-inline">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapsePreparedOrders" aria-expanded="true" aria-controls="collapsePreparedOrders">
          Your Orders
        </button>
      </h1>
      <div id="collapsePreparedOrders" class="collapse show" aria-labelledby="headingRestaurants">
        <div class="card-body">
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <div class="row">
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title">Order title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Order subtitle</h6>
                <p class="card-text">Example of an order text.</p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
$(function() {
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("nav div ul li a:contains('Orders')");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
