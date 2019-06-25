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
          <div class="card-body" id="ordersIncoming"></div>
        </div>
      <div class="card main-card">
        <h1 class="mb-0">
          <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapsePreparedOrders" aria-expanded="false" aria-controls="collapsePreparedOrders">
            Accepted Orders
          </button>
        </h1>
        <div id="collapsePreparedOrders" class="collapse" aria-labelledby="headingPreparedOrders" data-parent="#mainAccordion">
          <div class="card-body" id="ordersAccepted"></div>
        </div>
      </div>
      <div class="card main-card">
        <h1 class="mb-0">
          <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseCompletedOrders" aria-expanded="false" aria-controls="collapseCompletedOrders">
            Completed Orders
          </button>
        </h1>
        <div id="collapseCompletedOrders" class="collapse" aria-labelledby="headingCompletedOrders" data-parent="#mainAccordion">
          <div class="card-body" id="ordersCompleted"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
function fetchAwaitingOrders() {
  $.post("ajax/fetch_awaiting_orders.php")
  .done(function(response) {
    if (response !== 'EMPTY') {
      var responseArray = JSON.parse(response)
      // take all elements with a distinct order_id and create an "order" element for each order
      // distinct filter taken from https://stackoverflow.com/a/47313334
      var orders = []
      $.each(responseArray.filter(
        (arr, index, self) => index === self.findIndex(
          (t) => (t.order_id === arr.order_id))
        ),
        function(index, it) {
          console.log("ORDER")
          orders.push({
            order_id: it.order_id,
            client_name: it.client_name,
            creation_timestamp: it.creation_timestamp,
            order_address: it.order_address,
            status_id: it.status_id,
            products: []
          })
        }
      )
      // fill the orders with their respective products
      $.each(responseArray, function(index, it) {
        orders.filter(self => self.order_id === it.order_id)[0].products.push({
        // orders[it.order_id].products.push({
          product_name: it.product_name,
          quantity: it.quantity,
          notes: it.notes
        })
      })
      // order by date
      orders.sort(function(a, b) { return Date.parse(b.creation_timestamp) - Date.parse(a.creation_timestamp) })
      $.each(orders, function(index, it) {
        var element = `
        <div class="card orderCard mb-3" data-orderId="` + it.order_id + `">
          <div class="card-body">
            <div class="card-title">
              <h7 class="text-muted float-right">` + it.creation_timestamp + `</h7>
              <h5>` + (it.status_id != 2 ? it.client_name + `'s order` : `<strike>` + it.client_name + `'s order</strike>`) + `</h5>
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
              <button class="btn btn-primary inline btnAccept" onclick="btnAcceptClick(this)">Accept</button>
              <button class="btn btn-primary inline btnReject" onclick="btnRejectClick(this)">Reject</button>
            </div>
          </div>
        </div>`
        $("#ordersIncoming").append(element)
      })
    }
  })
  .always(function() {
    setTimeout(fetchAwaitingOrders, 1000)
  })
}

$(function() {
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("nav div ul li a:contains('Home')");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");
  // fetch all orders and place them in their section.
  $.post("ajax/fetch_recent_orders.php")
  .done(function(response) {
    if (response.indexOf('ERROR') != -1) {
      console.log(response)
    } else {
      var responseArray = JSON.parse(response)
      // take all elements with a distinct order_id and create an "order" element for each order
      // distinct filter taken from https://stackoverflow.com/a/47313334
      var allOrders = []
      $.each(responseArray.filter(
        (arr, index, self) => index === self.findIndex(
          (t) => (t.order_id === arr.order_id))
        ),
        function(index, it) {
          allOrders.push({
            order_id: it.order_id,
            client_name: it.client_name,
            creation_timestamp: it.creation_timestamp,
            order_address: it.order_address,
            status_id: it.status_id,
            products: []
          })
        }
      )
      // fill the orders with their respective products
      $.each(responseArray, function(index, it) {
        allOrders.filter(self => self.order_id === it.order_id)[0].products.push({
        // allOrders[it.order_id].products.push({
          product_name: it.product_name,
          quantity: it.quantity,
          notes: it.notes
        })
      })
      // order by date
      allOrders.sort(function(a, b) { return Date.parse(b.creation_timestamp) - Date.parse(a.creation_timestamp) })
      // put each order in its section
      $.each(allOrders, function(index, it) {
        var element = `
        <div class="card orderCard mb-3" data-orderId="` + it.order_id + `">
          <div class="card-body">
            <div class="card-title">
              <h7 class="text-muted float-right">` + it.creation_timestamp + `</h7>
              <h5>` + (it.status_id != 2 ? it.client_name + `'s order` : `<strike>` + it.client_name + `'s order</strike>`) + `</h5>
            </div>
            <h5 class="card-title"></h5>
            <h6 class="card-subtitle mb-2 text-muted">` + it.order_address + `</h6>`
        if (it.status_id == 4) {
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
                <button class="btn btn-primary inline btnAccept" onclick="btnAcceptClick(this)">Accept</button>
                <button class="btn btn-primary inline btnReject" onclick="btnRejectClick(this)">Reject</button>
              </div>
            </div>
          </div>`
          $("#ordersIncoming").prepend(element)
        } else if (it.status_id == 1) {
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
                <button class="btn btn-primary inline" onclick="btnCompleteClick(this)">Complete</button>
              </div>
            </div>
          </div>`
          $("#ordersAccepted").prepend(element)
        } else {
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
  })
  .always(function() {
    setTimeout(fetchAwaitingOrders, 1000)
  })
})

function btnAcceptClick(e) {
  var orderId = $(e).parent().parent().parent().data('orderid')
  $.post("ajax/change_order_state.php", {
    order_id: orderId,
    new_state: 1
  }).done(function(result) {
    if (result === "SUCCESS") {
      var buttonBar = $(e).parent()
      var orderCard = buttonBar.parent().parent()
      orderCard.slideUp(400, function() {
        orderCard.detach().appendTo("#ordersAccepted")
        buttonBar.children().remove()
        buttonBar.append('<button class="btn btn-primary inline" onclick="btnCompleteClick(this)">Complete</button>')
        orderCard.show()
      })
    } else {
      console.log(result)
    }
  })
}

function btnRejectClick(e) {
  var orderId = $(e).parent().parent().parent().data('orderid')
  $.post("ajax/change_order_state.php", {
    order_id: orderId,
    new_state: 2
  }).done(function(result) {
    if (result === "SUCCESS") {
      var buttonBar = $(e).parent()
      var orderCard = buttonBar.parent().parent()
      orderCard.slideUp(400, function() {
        orderCard.detach().appendTo("#ordersCompleted")
        buttonBar.children().remove()
        buttonBar.append('<button class="btn btn-primary inline" onclick="btnCompleteClick(this)">Complete</button>')
        orderCard.show()
        var cardTitle = orderCard.find(".card-title h5")
        cardTitle.html("<strike>" + cardTitle.text() + "</strike>")
      })
    } else {
      console.log(result)
    }
  })
}

function btnCompleteClick(e) {
  var orderId = $(e).parent().parent().parent().data('orderid')
  $.post("ajax/change_order_state.php", {
    order_id: orderId,
    new_state: 3
  }).done(function(result) {
    if (result === "SUCCESS") {
      var buttonBar = $(e).parent()
      var orderCard = buttonBar.parent().parent()
      orderCard.slideUp(400, function() {
        orderCard.detach().appendTo("#ordersCompleted")
        buttonBar.children().remove()
        buttonBar.append('<button class="btn btn-primary inline" onclick="btnCompleteClick(this)">Complete</button>')
        orderCard.show()
      })
    } else {
      console.log(result)
    }
  })
}

</script>
<?php include("fragments/connection-end.php"); ?>
</html>
