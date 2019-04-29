<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "client") {
    header('Location: home_clients.php');
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
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseIncomingOrders" aria-expanded="true" aria-controls="collapseIncomingOrders">
          Incoming Orders
        </button>
      </h1>
      <div id="collapseIncomingOrders" class="collapse show" aria-labelledby="headingIncomingOrders">
        <div class="card-body">
          <div class="row">
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title">Order title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Order subtitle</h6>
                <p class="card-text">This is an example of an order text</p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Accept</a>
                  <a href="#" class="btn btn-primary inline">Reject</a>
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapsePreparedOrders" aria-expanded="false" aria-controls="collapsePreparedOrders">
          Prepared Orders
        </button>
      </h1>
      <div id="collapsePreparedOrders" class="collapse" aria-labelledby="headingPreparedOrders">
        <div class="card-body">
          <div class="row">
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title">Order title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Order subtitle</h6>
                <p class="card-text">This is an example of an order text</p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Accept</a>
                  <a href="#" class="btn btn-primary inline">Reject</a>
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseCompletedOrders" aria-expanded="false" aria-controls="collapseCompletedOrders">
          Completed Orders
        </button>
      </h1>
      <div id="collapseCompletedOrders" class="collapse" aria-labelledby="headingCompletedOrders">
        <div class="card-body">
          <div class="row">
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title">Order title</h5>
                <h6 class="card-subtitle mb-2 text-muted">Order subtitle</h6>
                <p class="card-text">This is an example of an order text</p>
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
<?php include("fragments/connection-end.php"); ?>
</html>
