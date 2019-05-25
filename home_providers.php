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
        <div class="card-body" id="ordersIncoming">
          <!-- <div class="card orderCard" data-orderId="5">
            <div class="card-body">
              <h5 class="card-title">Bob's order</h5>
              <h6 class="card-subtitle mb-2 text-muted">Order address</h6>
              <div class="card-text">
                <div class="border p-2">
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Product</label>
                    <label class="col col-form-label">Product name</label>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Quantity</label>
                    <label class="col col-form-label">2</label>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Notes</label>
                    <label class="col col-form-label">Notes 1 Blabla blabla</label>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
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
        </div>
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
    data: {
      order_recency: "ALL"
    },
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
              client_name: it.client_name,
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
        // TODO: order the orders by creation_timestamp
        $.each(allOrders, function(index, it) {
          if (it.status_id == 4) {
            var element = `
            <div class="card orderCard mb-3" data-orderId="` + index + `">
              <div class="card-body">
                <div class="card-title">
                  <h7 class="text-muted float-right">` + it.creation_timestamp + `</h7>
                  <h5>` + it.client_name + `'s order</h5>
                </div>
                <h5 class="card-title"></h5>
                <h6 class="card-subtitle mb-2 text-muted">` + it.order_address + `</h6>`
            $.each(it.products, function(index, orderedProduct) {
              element += `
              <div class="card-text">
                <div class="border-top border-bottom p-2">
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Product</label>
                    <label class="col col-form-label">` + orderedProduct.product_name + `</label>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Quantity</label>
                    <label class="col col-form-label">` + orderedProduct.quantity + `</label>
                  </div>`
              if (orderedProduct.notes != "") {
                element += `
                <div class="row">
                  <label class="col-sm-2 col-form-label border-right">Notes</label>
                  <label class="col col-form-label">` + orderedProduct.notes + `</label>
                </div>`
              }
              element += `
                  </div>
                </div>`
            })
            element += `
                <div class="btn-group btn-group-justified pt-2">
                  <a href="#" class="btn btn-primary inline">Accept</a>
                  <a href="#" class="btn btn-primary inline">Reject</a>
                </div>
              </div>
            </div>`
            $("#ordersIncoming").prepend(element)
          } else if (it.status_id == 1) {
            var element = `
            <div class="card orderCard mb-3" data-orderId="` + index + `">
              <div class="card-body">
                <div class="card-title">
                  <h7 class="text-muted float-right">` + it.creation_timestamp + `</h7>
                  <h5>` + it.client_name + `'s order</h5>
                </div>
                <h5 class="card-title"></h5>
                <h6 class="card-subtitle mb-2 text-muted">` + it.order_address + `</h6>`
            $.each(it.products, function(index, orderedProduct) {
              element += `
              <div class="card-text">
                <div class="border-top border-bottom p-2">
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Product</label>
                    <label class="col col-form-label">` + orderedProduct.product_name + `</label>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Quantity</label>
                    <label class="col col-form-label">` + orderedProduct.quantity + `</label>
                  </div>`
              if (orderedProduct.notes != "") {
                element += `
                <div class="row">
                  <label class="col-sm-2 col-form-label border-right">Notes</label>
                  <label class="col col-form-label">` + orderedProduct.notes + `</label>
                </div>`
              }
              element += `
                  </div>
                </div>`
            })
            element += `
                <div class="btn-group btn-group-justified pt-2">
                  <a href="#" class="btn btn-primary inline">Complete</a>
                </div>
              </div>
            </div>`
            $("#ordersAccepted").prepend(element)
          } else {
            var element = `
            <div class="card orderCard mb-3" data-orderId="` + index + `">
              <div class="card-body">
                <div class="card-title">
                  <h7 class="text-muted float-right">` + it.creation_timestamp + `</h7>
                  <h5>` + it.client_name + `'s order</h5>
                </div>
                <h5 class="card-title"></h5>
                <h6 class="card-subtitle mb-2 text-muted">` + it.order_address + `</h6>`
            $.each(it.products, function(index, orderedProduct) {
              element += `
              <div class="card-text">
                <div class="border-top border-bottom p-2">
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Product</label>
                    <label class="col col-form-label">` + orderedProduct.product_name + `</label>
                  </div>
                  <div class="row">
                    <label class="col-sm-2 col-form-label border-right">Quantity</label>
                    <label class="col col-form-label">` + orderedProduct.quantity + `</label>
                  </div>`
              if (orderedProduct.notes != "") {
                element += `
                <div class="row">
                  <label class="col-sm-2 col-form-label border-right">Notes</label>
                  <label class="col col-form-label">` + orderedProduct.notes + `</label>
                </div>`
              }
              element += `
                  </div>
                </div>`
            })
            element += `
              </div>
            </div>`
            $("#ordersCompleted").prepend(element)
          }
        })
      }
    }
  })

  // fetchAwaitingOrders()
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
