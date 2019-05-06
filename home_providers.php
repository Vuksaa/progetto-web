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

  <div class="container mt-4 mb-4">
    <h3 class="pb-2">Order list</h3>
    <div class="container accordion mt-4 mb-4" id="mainAccordion">
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseIncomingOrders" aria-expanded="true" aria-controls="collapseIncomingOrders">
          Incoming Orders
        </button>
      </h1>
      <div id="collapseIncomingOrders" class="collapse show" aria-labelledby="headingIncomingOrders" data-parent="#mainAccordion">
        <?php
        //Sort all orders based on status (1=incoming,2=prepared,3=completed)
        $incomingOrders = array();
        $preparedOrders = array();
        $completedOrders = array();
          if ($allOrders = $conn->query("SELECT o.order_id,o.order_address,p.product_name,s.status_name,s.status_id,po.notes
                                      FROM uni_web_prod.order o
                                      JOIN product_order po
                                      ON o.order_id = po.order_id
                                      JOIN product p
                                      ON po.product_id = p.product_id
                                      JOIN order_status os
                                      ON os.order_id = o.order_id
                                      LEFT JOIN status s
                                      ON os.status_id = s.status_id
                                      WHERE p.provider_id = '".$_SESSION['user_id']."'
                                      ORDER BY s.status_id ASC")) {
            while ($orderRow = $allOrders->fetch_assoc()) {
              if($orderRow['status_id'] == 1) {
                $incomingOrders[] = $orderRow;
              } else if($orderRow['status_id'] == 2) {
                $preparedOrders[] = $orderRow;
              } else {
                $completedOrders[] = $orderRow;
              }
            }
         $allOrders->close();
        } else {
          echo "Query failed";
        }
        ?>
        <div class="card-body">
          <div class="row">
            <?php
            foreach ($incomingOrders as $incomingOrder) {
             ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title"><?php echo $incomingOrder['product_name'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $incomingOrder['order_address'] ?></h6>
                <p class="card-text"><?php echo $incomingOrder['notes'] ?></p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Accept</a>
                  <a href="#" class="btn btn-primary inline">Reject</a>
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
          <?php } ?>
          </div>
        </div>
      </div>
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapsePreparedOrders" aria-expanded="false" aria-controls="collapsePreparedOrders">
          Prepared Orders
        </button>
      </h1>
      <div id="collapsePreparedOrders" class="collapse" aria-labelledby="headingPreparedOrders" data-parent="#mainAccordion">
        <div class="card-body">
          <div class="row">
            <?php
            foreach ($preparedOrders as $preparedOrder) {
             ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title"><?php echo $preparedOrder['product_name'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $preparedOrder['order_address'] ?></h6>
                <p class="card-text"><?php echo $preparedOrder['notes'] ?></p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Accept</a>
                  <a href="#" class="btn btn-primary inline">Reject</a>
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
          <?php } ?>
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
      <div id="collapseCompletedOrders" class="collapse" aria-labelledby="headingCompletedOrders" data-parent="#mainAccordion">
        <div class="card-body">
          <div class="row">
            <?php
            foreach ($completedOrders as $completedOrder) {
             ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title"><?php echo $completedOrder['product_name'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $completedOrder['order_address'] ?></h6>
                <p class="card-text"><?php echo $completedOrder['notes'] ?></p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
          <?php } ?>
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
  var element = $("nav div ul li a:contains('Home')");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
