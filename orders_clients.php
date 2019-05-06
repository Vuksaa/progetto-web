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

  <div class="container mt-4 mb-4">
    <h3 class="pb-2">Order History</h3>
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseOrderHistory" aria-expanded="true" aria-controls="collapseOrderHistory">
          Your Orders
        </button>
      </h1>
      <div id="collapseOrderHistory" class="collapse show" aria-labelledby="headingOrderHistory">
        <div class="card-body">
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <div class="row">
            <?php
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
                                          JOIN client_order co
                                          ON co.order_id = o.order_id
                                          WHERE co.client_id = '".$_SESSION['user_id']."'")) {
                while ($orderRow = $allOrders->fetch_assoc()) {
            ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <h5 class="card-title"><?php echo $orderRow['product_name'] ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $orderRow['order_address'] ?></h6>
                <p class="card-text"><?php echo $orderRow['notes'] ?></p>
                <div class="btn-group btn-group-justified">
                  <a href="#" class="btn btn-primary inline">Details</a>
                </div>
              </div>
            </div>
            <?php
              }
              } else {
                  echo "Query failed";
                }
            ?>
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
