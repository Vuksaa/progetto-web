<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "provider") {
    header('Location: profile_providers.php');
    exit();
  }
?>
<?php include("fragments/connection-begin.php"); ?>
<!DOCTYPE html>
<html lang="it">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <?php include("fragments/navbar.php"); ?>
  <div class="container mt-4 mb-4">
    <section>
      <h1 class="display-4 mb-4 text-center text-sm-left">Ordini aperti</h1>
      <div id="openOrders" class="d-none">
      </div>
    </section>
    <section>
      <h1 class="display-4 mb-4 text-center text-sm-left">Ordini chiusi</h1>
      <div id="closedOrders" class="d-none">
      </div>
      <button class="btn btn-primary btn-sm col col-sm-2 mt-2" id="showMore">
        Mostra altri
      </button>
    </section>
  </div>
  <?php include("fragments/footer.php"); ?>
  <script>
  $(function() {
    /* Set navbar voice active with respective screen reader functionality */
    var element = $("#navbarOrders");
    var parent = element.parent();
    element.append( "<span class='sr-only'>(current)</span>" );
    parent.addClass("active");

    var nextHiddenOrderGroup = 0
    function showNextOrders() {
      $("#closedOrders .orderCard").filter(function() {
        return ($(this).data("order-group") == nextHiddenOrderGroup)
      }).removeClass("d-none")
      nextHiddenOrderGroup++
    }
    $("#showMore").on('click', showNextOrders)

    // fetch all orders and place them in their section.
    $.post("ajax/fetch_client_closed_orders.php")
    .done(function(response) {
      if (response.indexOf('ERROR') != -1 || response == 'EMPTY') {
        console.log(response)
      } else {
        $("#closedOrders").removeClass('d-none')
        var responseArray = JSON.parse(response)
        // take all elements with a distinct order_id and create an "order" element for each order
        // distinct filter taken from https://stackoverflow.com/a/47313334
        var orders = []
        $.each(responseArray.filter(
          (arr, index, self) => index === self.findIndex(
            (t) => (t.order_id === arr.order_id))
          ),
          function(index, it) {
            orders.push({
              provider_id: it.provider_id,
              order_id: it.order_id,
              provider_name: it.provider_name,
              creation_timestamp: it.creation_timestamp,
              order_address: it.order_address,
              status_name: it.status_name,
              rejection_reason: it.rejection_reason,
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
        // create the order cards
        var orderNumber = 0;
        var orderGroupSize = 5;
        $.each(orders, function(index, it) {
          var card = createOrderCard(it)
          card.addClass('d-none')
          card.data('order-group', parseInt(orderNumber++ / orderGroupSize))
          card.appendTo($("#closedOrders"))
        })
        showNextOrders()
      }
    })
    $.post("ajax/fetch_client_open_orders.php")
    .done(function(response) {
      if (response.indexOf('ERROR') != -1 || response == 'EMPTY') {
        console.log(response)
      } else {
        $("#openOrders").removeClass('d-none')
        var responseArray = JSON.parse(response)
        // take all elements with a distinct order_id and create an "order" element for each order
        // distinct filter taken from https://stackoverflow.com/a/47313334
        var orders = []
        $.each(responseArray.filter(
          (arr, index, self) => index === self.findIndex(
            (t) => (t.order_id === arr.order_id))
          ),
          function(index, it) {
            orders.push({
              provider_id: it.provider_id,
              order_id: it.order_id,
              provider_name: it.provider_name,
              creation_timestamp: it.creation_timestamp,
              order_address: it.order_address,
              status_name: it.status_name,
              rejection_reason: it.rejection_reason,
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
        // create the order cards
        var orderNumber = 0;
        var orderGroupSize = 5;
        $.each(orders, function(index, it) {
          var card = createOrderCard(it)
          card.appendTo($("#openOrders"))
        })
      }
    })
  })

  function createOrderCard(o) {
    var element = `
    <div class="card orderCard mb-3">
      <div class="card-body">
        <div class="card-title">
          <h6>` + o.status_name + (o.rejection_reason == null || o.rejection_reason == '' ? '' : `. Motivo: ` + o.rejection_reason) + `</h6>
          <p class="text-muted float-right">` + o.creation_timestamp + `</p>
          <a class="h5" href="place_order.php?provider=` + o.provider_id + `">` + o.provider_name + `</a>
        </div>
        <p class="card-subtitle mb-2 text-muted">` + o.order_address + `</p>`
    $.each(o.products, function(index, orderedProduct) {
      element += `
      <div class="card-text">
        <hr>
        <div class="p-2">
          <div class="row">
            <label class="col-4 col-sm-3 col-lg-2 col-form-label border-right">Prodotto</label>
            <label class="col col-form-label">` + orderedProduct.product_name + `</label>
          </div>
          <div class="row">
            <label class="col-4 col-sm-3 col-lg-2 col-form-label border-right">Quantit&agrave;</label>
            <label class="col col-form-label">` + orderedProduct.quantity + `</label>
          </div>`
      if (orderedProduct.notes != "") {
        element += `
        <div class="row">
          <label class="col-4 col-sm-3 col-lg-2 col-form-label border-right">Note</label>
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
    return $(element)
  }
  </script>
</body>
<?php include("fragments/connection-end.php"); ?>
</html>
