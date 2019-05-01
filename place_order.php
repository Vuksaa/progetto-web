<?php include("fragments/logged-check.php"); ?>
<?php include("fragments/connection-begin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
  <!-- The provider's ID should be in $_GET['provider'] -->
  <?php include("fragments/navbar.php"); ?>
  <div class="container pt-4 pb-4">
    <h3 class="pb-2">Place order</h3>

    <div class="container accordion mt-4 mb-4" id="mainAccordion">
      <div class="card main-card">
        <button class="btn btn-secondary btn-lg btn-block active" id="headingMenu" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseMenu">
          Menu
        </button>
        <div id="collapseMenu" class="collapse show" aria-labelledby="headingMenu" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card-searchbar">
              <input class="form-control mr-sm-2" id="searchProducts" type="search" placeholder="Search" aria-label="Search">
            </form>

            <?php
            if ($listedProducts = $conn->query("
            SELECT product_id, product_name, product_price
            FROM provider
            JOIN product
            ON provider.provider_id = product.provider_id
            WHERE provider.provider_id ='".$_GET['provider']."'
            ")) {
              while ($product = $listedProducts->fetch_assoc()) {
                ?>
                <div class="card">
                  <div class="card-body">
                    <h6 class="card-title"><?php echo $product['product_name']; ?></h5>
                    <p class="card-text font-weight-light">Ingredient 1, Ingredient 2, Ingredient 3</p>
                    <form class="form-group row">
                      <label class="col-sm-2 col-form-label">Price</label>
                      <label class="col-sm-1 col-form-label"><?php echo $product['product_price']." €"; ?></label>
                    </form>
                    <form class="form-group row">
                      <label for="product<?php echo $product['product_id']; ?>Quantity" class="col-sm-2 col-form-label">Quantity</label>
                      <input type="number" class="form-control col-sm-1" id="product<?php echo $product['product_id']; ?>Quantity" placeholder="Quantity" value="1" required>
                    </form>
                    <form class="form-group row">
                      <label for="product<?php echo $product['product_id']; ?>Notes" class="col-sm-2 col-form-label">Notes</label>
                      <textarea class="form-control col-sm-5" id="product<?php echo $product['product_id']; ?>Notes"></textarea>
                    </form>
                    <a href="#" class="btn btn-primary far fa-plus-square"></a>
                  </div>
                </div>
                <?php
              }
            }
            ?>
          </div>
        </div>
      </div>
      <div class="card main-card">
        <button class="btn btn-secondary btn-lg btn-block active" id="headingOrder" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="false" aria-controls="collapseOrder">
          Order
        </button>
        <div id="collapseOrder" class="collapse" aria-labelledby="headingOrder" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card">
              <div class="card-body" id="orderedProductIDCard">
                <h6 class="card-title">Product name</h5>
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
          </div>
        </div>
      </div>
      <div class="card main-card">
        <button class="btn btn-secondary btn-lg btn-block active" id="headingConfirmation" data-toggle="collapse" data-target="#collapseConfirmation" aria-expanded="false" aria-controls="collapseConfirmation">
          Address &amp; Confirmation
        </button>
        <div id="collapseConfirmation" class="collapse" aria-labelledby="headingConfirmation" data-parent="#mainAccordion">
          <div class="card-body">
            <form class="pt-2">
              <div class="form-group">
                <div class="form-check custom-radio">
                  <input class="form-check-input" type="radio" id="radioSelectAddress" name="addressRadio" checked>
                  <label class="form-check-label" for="radioSelectAddress">Select address</label>
                </div>
                <div class="form-check custom-radio">
                  <input class="form-check-input" type="radio" id="radioEnterAddress" name="addressRadio">
                  <label class="form-check-label" for="radioEnterAddress">Enter address</label>
                </div>
              </div>
              <div class="form-group pt-2" id="formSelectAddress">
                <select class="custom-select col-sm-3" required>
                  <?php
                  if ($addresses = $conn->query("
                    SELECT a.address_name, a.address_info
                    FROM client c
                    JOIN address a
                    ON a.client_id = c.client_id
                    WHERE a.client_id = '".$_SESSION['user_id']."'
                    ")) {
                    echo '<option value="">Select address</option>';
                    while ($address = $addresses->fetch_assoc()) {
                      echo '<option value="'.$address['address_info'].'">'.$address['address_info'].'</option>';
                    }
                  } else {
                    echo '<option value="">No addresses set</option>';
                  }
                  ?>
                </select>
              </div>
              <!-- created with the d-none class so that it doesn't briefly show up before the DOM is ready -->
              <div class="form-group pt-2 d-none" id="formEnterAddress">
                <div class="form-group row">
                  <label for="enteredAddress" class="col-form-label col-sm-auto">Address</label>
                  <input type="text" class="form-control col-sm-4" id="enteredAddress" placeholder="Address" required>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="custom-control-input" value="" id="checkSaveAddress">
                  <label class="custom-control-label" for="checkSaveAddress">Save this address</label>
                </div>
                <div class="form-group row pt-1 d-none" id="formEnterAddressName">
                  <label for="enteredAddressName" class="col-form-label col-sm-auto">Name</label>
                  <input type="text" class="form-control col-sm-2" id="enteredAddressName" placeholder="Name">
                </div>
              </div>
            <button type="button" id="btnComplete" class="btn btn-primary mt-4">Pay and order</button>
          </form>
          </div>
        </div>
      </div>
    </div>
  <?php
  include("fragments/footer.php");
  ?>
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

  $("#searchProducts").on('keyup', function(e) {
    var inputed = $(this).val().toLowerCase()
    var items = $("#listedProducts .card")
    if (inputed == "") {
      items.show()
      return
    }
    $.each(items, function() {
      var providerName = $(this).find(".card-title").text().toLowerCase()
      if (providerName.indexOf(inputed) == -1) {
        $(this).hide()
      } else {
        $(this).show()
      }
    })
  })
})
</script>

<?php include("fragments/connection-end.php"); ?>
</html>
