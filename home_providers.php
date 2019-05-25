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
          if ($allOrders = $conn->query(
            "SELECT o.order_id, o.order_address, p.product_name, s.status_name, s.status_id, po.notes, o.creation_timestamp
            FROM uni_web_prod.order o
            JOIN product_order po
            ON o.order_id = po.order_id
            JOIN product p
            ON po.product_id = p.product_id
            LEFT JOIN status s
            ON o.status_id = s.status_id
            WHERE p.provider_id = '".$_SESSION['user_id']."'
            ORDER BY o.creation_timestamp ASC, o.order_id ASC"
          )) {
            while ($orderRow = $allOrders->fetch_assoc()) {
              if($orderRow['status_id'] == 4) {
                $incomingOrders[] = $orderRow;
              } else if($orderRow['status_id'] == 1) {
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
        <div class="card-body" id="ordersIncoming">
          <?php
          foreach ($incomingOrders as $incomingOrder) {
           ?>
          <div class="card" data-orderId="<?php echo $incomingOrder['order_id']; ?>">
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
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapsePreparedOrders" aria-expanded="false" aria-controls="collapsePreparedOrders">
          Prepared Orders
        </button>
      </h1>
      <div id="collapsePreparedOrders" class="collapse" aria-labelledby="headingPreparedOrders" data-parent="#mainAccordion">
        <div class="card-body" id="ordersAccepted">
          <?php
          foreach ($preparedOrders as $preparedOrder) {
           ?>
          <div class="card" data-orderId="<?php echo $preparedOrder['order_id']; ?>">
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
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseCompletedOrders" aria-expanded="false" aria-controls="collapseCompletedOrders">
          Completed Orders
        </button>
      </h1>
      <div id="collapseCompletedOrders" class="collapse" aria-labelledby="headingCompletedOrders" data-parent="#mainAccordion">
        <div class="card-body" id="ordersCompleted">
          <?php
          foreach ($completedOrders as $completedOrder) {
           ?>
          <div class="card" data-orderId="<?php echo $completedOrder['order_id']; ?>">
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

  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
<?php
if (!isset($_SESSION['statement_fetch_awaiting_orders'])) {
  $_SESSION['statement_fetch_awaiting_orders'] = $conn->prepare(
    "SELECT o.order_id, o.order_address, p.product_name, s.status_name, s.status_id, po.notes, o.creation_timestamp
    FROM uni_web_prod.order o
    JOIN product_order po
    ON o.order_id = po.order_id
    JOIN product p
    ON po.product_id = p.product_id
    LEFT JOIN status s
    ON o.status_id = s.status_id
    WHERE p.provider_id = '".$_SESSION['user_id']."'
    AND o.status_id = 4
    ORDER BY o.creation_timestamp ASC, o.order_id ASC"
  );
}
?>
function fetchAwaitingOrders() {
  $.ajax({
    url: "ajax/fetch_awaiting_orders.php",
    method: get,
    success: function(response) {

    },
    complete: function() {
      setTimeout(fetchAwaitingOrders, 5000);
    }
  })
}
$(function() {
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("nav div ul li a:contains('Home')");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");

  // fetch all orders and place them in their section.
  $.post({
    url: "ajax/fetch_recent_orders.php",
    success: function(response) {
      if (response === 'ERROR') {
        alert("ERROR");
      } else {
        var responseArray = JSON.parse(response)
        // take all elements with a distinct order_id and create an "order" element for each order
        // distinct filter taken from https://stackoverflow.com/a/47313334
        var allOrders = {}
        $.each(responseArray.filter(
          (arr, index, self) => index === self.findIndex(
            (t) => (t.order_id === arr.order_id))
          ),
          function(index, it) {
            allOrders[it.order_id] = {
              creation_timestamp: it.creation_timestamp,
              order_address: it.order_address,
              status_id: it.status_id,
              products: []
            }
          }
        )
        // fill the orders with their respective products
        $.each(responseArray, function(index, it) {
          allOrders[it.order_id].products.push({
            product_name: it.product_name,
            quantity: it.quantity,
            notes: it.notes
          })
        })
        // TODO: place each order in its section
        // $.each(allOrders, function(index, it) {
        //   if (it.status_id === 4) {
        //     $("#ordersIncoming").prepend('')
        //   }
        // })
      }
    }
  })

  // fetchAwaitingOrders()
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
