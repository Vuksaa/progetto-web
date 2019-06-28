<?php
include("fragments/logged-check.php");
include("fragments/connection-begin.php");
?>
<!DOCTYPE html>
<html lang="it">

<head>
  <?php include("fragments/head-contents.php"); ?>
  <link rel="stylesheet" type="text/css" href="styles/base.css">
  <style>
  .form-inline .col-form-label {
    text-align: left;
  }
  </style>
</head>

<body>
  <!-- The provider's ID should be in $_GET['provider'] -->
  <?php include("fragments/navbar.php"); ?>
  <div class="container mt-4 mb-4">
    <h4 class="display-4 pb-2">Crea ordine</h4>

    <div class="container accordion mt-4 mb-4" id="mainAccordion">
      <div class="card main-card">
        <button class="btn btn-secondary btn-lg btn-block active" id="headingMenu" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseMenu">
          Men&ugrave;
        </button>
        <div id="collapseMenu" class="collapse show" aria-labelledby="headingMenu" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card-searchbar">
              <input class="form-control" id="searchProducts" type="search" placeholder="Search" aria-label="Search">
            </div>
            <div id="listedProducts">
              <?php
              // temporary value for testing purposes
              $productGroupSize = 5;
              if ($listedProducts = $conn->query("
              SELECT *
              FROM product_by_provider
              WHERE provider_id ='".$_GET['provider']."'
              ")) {
                $productNumber = 0;
                while ($product = $listedProducts->fetch_assoc()) {
                  ?>
                  <div class="card mt-2 productCard d-none" data-product-group="<?php echo (int)($productNumber / $productGroupSize); ?>" data-product-id="<?php echo $product['product_id']; ?>">
                    <div class="card-body">
                      <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                      <p class="card-text font-weight-light pb-3">
                        <?php
                        if ($ingredients = $conn->query("
                        SELECT *
                        FROM ingredient_by_product
                        WHERE product_id = '".$product['product_id']."'
                        ")) {
                          $ingredient = $ingredients->fetch_assoc();
                          echo $ingredient['ingredient_name'];
                          while ($ingredient = $ingredients->fetch_assoc()) {
                            echo ", ".$ingredient['ingredient_name'];
                          }
                        }
                        ?>
                      </p>
                      <form class="form-group form-inline">
                        <label class="col-form-label col-4 col-sm-3 col-md-2 justify-content-start" for="product<?php echo $product['product_id']; ?>Price">Price</label>
                        <label class="col-form-label" id="product<?php echo $product['product_id']; ?>Price"><?php echo $product['product_price']." €"; ?></label>
                      </form>
                      <form class="form-group form-inline">
                        <label class="col-form-label col-4 col-sm-3 col-md-2 justify-content-start" for="product<?php echo $product['product_id']; ?>Quantity">Quantity</label>
                        <input class="form-control col-2 col-md-1 productQuantity" type="number" id="product<?php echo $product['product_id']; ?>Quantity" placeholder="Quantity" value="1" required>
                      </form>
                      <form class="form-group form-inline">
                        <label class="col-form-label col-4 col-sm-3 col-md-2 justify-content-start" for="product<?php echo $product['product_id']; ?>Notes">Notes</label>
                        <textarea class="form-control col-sm-6 productNotes" id="product<?php echo $product['product_id']; ?>Notes"></textarea>
                      </form>
                      <button class="btn btn-primary btnAddProduct col col-sm-2 col-md-1">
                        <i class="far fa-plus-square"></i>
                      </button>
                      <button class="btn btn-primary btnRemoveProduct col col-sm-2 col-md-1">
                        <i class="far fa-minus-square"></i>
                      </button>
                    </div>
                  </div>
                  <?php
                  $productNumber = $productNumber + 1;
                }
              }
              ?>
            </div>
            <button class="btn btn-primary btn-sm col col-sm-2 mt-2" id="productsShowMore">
              Mostra altri
            </button>
        </div>
      </div>
    </div>
    <div class="card main-card">
      <button class="btn btn-secondary btn-lg btn-block active" id="headingOrder" data-toggle="collapse" data-target="#collapseOrder" aria-expanded="false" aria-controls="collapseOrder">
        Ordine
      </button>
        <div id="collapseOrder" class="collapse" aria-labelledby="headingOrder" data-parent="#mainAccordion">
          <div class="card-body">
            <div id="toOrderProducts">
            </div>
          </div>
        </div>
        </div>
        <div class="card main-card">
          <button class="btn btn-secondary btn-lg btn-block active" id="headingConfirmation" data-toggle="collapse" data-target="#collapseConfirmation" aria-expanded="false" aria-controls="collapseConfirmation">
            Indirizzo e conferma
          </button>
          <div id="collapseConfirmation" class="collapse" aria-labelledby="headingConfirmation" data-parent="#mainAccordion">
            <div class="card-body">
              <form class="pt-2">
                <div class="form-group">
                  <div class="form-check custom-radio">
                    <input class="form-check-input" type="radio" id="radioSelectAddress" name="addressRadio" checked>
                    <label class="form-check-label" for="radioSelectAddress">Indirizzo salvato</label>
                  </div>
                  <div class="form-check custom-radio">
                    <input class="form-check-input" type="radio" id="radioEnterAddress" name="addressRadio">
                    <label class="form-check-label" for="radioEnterAddress">Indirizzo nuovo</label>
                  </div>
                </div>
                <div class="form-group pt-2" id="formSelectAddress">
                  <select class="custom-select col-6 col-sm-5 col-md-4" id="selectedAddress" required>
                    <?php
                    if ($addresses = $conn->query("
                      SELECT a.address_name, a.address_info
                      FROM client c
                      JOIN address a
                      ON a.client_id = c.client_id
                      WHERE a.client_id = '".$_SESSION['user_id']."'
                      ")) {
                      echo '<option value="">Seleziona indirizzo</option>';
                      while ($address = $addresses->fetch_assoc()) {
                        echo '<option value="'.$address['address_info'].'">'.$address['address_info'].'</option>';
                      }
                    } else {
                      echo '<option value="">Nessun indirizzo salvato</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group pt-2" id="formEnterAddress">
                  <div class="form-group row">
                    <label for="enteredAddress" class="col-form-label col-sm-auto">Indirizzo</label>
                    <input type="text" class="form-control col-sm-4" id="enteredAddress" placeholder="Via e nr. civico" required>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="custom-control-input" value="" id="checkSaveAddress">
                    <label class="custom-control-label" for="checkSaveAddress">Salva indirizzo</label>
                  </div>
                  <div class="form-group row pt-1" id="formEnterAddressName">
                    <label for="enteredAddressName" class="col-form-label col-sm-auto">Nome</label>
                    <input type="text" class="form-control col-sm-2" id="enteredAddressName" placeholder="Nome">
                  </div>
                </div>
              <button type="button" id="btnComplete" class="btn btn-primary mt-4">Paga e ordina</button>
              <div class="alert alert-danger mt-2" role="alert">
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalOrderPlaced" tabindex="-1" role="dialog" aria-labelledby="modalLabelOrderPlaced" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelOrderPlaced">Ordine creato</h5>
          <button type="button" class="close" aria-label="Close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>L'ordine è stato spedito al fornitore!</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary ml-2" data-dismiss="modal">
            Ok
          </button>
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
  $('#modalOrderPlaced').on('hide.bs.modal', function (e) {
    window.location.href = "home_clients.php"
  })
  $(".alert").hide()
  // Hide "enter address" form, and add event handlers for hiding the appropriate form on the radiobuttons
  $("#formEnterAddress").hide()
  $("#radioEnterAddress").on('change', function(e) {
    $("#formEnterAddress").show()
    $("#formSelectAddress").hide()
  })
  $("#radioSelectAddress").on('change', function(e) {
    $("#formEnterAddress").hide()
    $("#formSelectAddress").show()
  })

  // hide the field for entering the address name if the user doesn't wish to save it. it is hidden by default
  $("#formEnterAddressName").hide()
  $("#checkSaveAddress").on('change', function(e) {
    if ($(this).is(":checked") == true) {
      $("#formEnterAddressName").show()
    } else {
      $("#formEnterAddressName").hide()
    }
  })

  // filter the listed products whenever the searchbar's text changes
  $("#searchProducts").on('keyup', function(e) {
    var inputed = $(this).val().toLowerCase()
    var items = $("#listedProducts .productCard")
    // show all listed product if the searchbar is blank
    if (inputed == "") {
      items.show()
      return
    }
    $.each(items, function() {
      var productName = $(this).find(".card-title").text().toLowerCase()
      // true if the text inputed in the searchbar is not contained in the product's name
      if (productName.indexOf(inputed) == -1) {
        $(this).hide()
      } else {
        $(this).show()
      }
    })
  })

  // function for showing products when the "show more" button is clicked.
  // the class d-none is used because the searchbar already hides products with the hide function
  var nextHiddenProductGroup = 0
  function showNextProducts() {
    $(".productCard").filter(function() {
      return ($(this).data("product-group") == nextHiddenProductGroup)
    }).removeClass("d-none")
    nextHiddenProductGroup++
  }
  showNextProducts()
  $("#productsShowMore").on('click', showNextProducts)

  // hide "-" buttons on each product card, since at first the order is empty
  $(".btnRemoveProduct").hide()
  $(".btnAddProduct").on('click', function(e) {
    var productCard = $(this).parent().parent()
    productCard.slideUp(400, function() {
      productCard.detach().appendTo("#toOrderProducts")
      productCard.find(".btnAddProduct").hide()
      productCard.find(".btnRemoveProduct").show()
      productCard.show()
    })
  })
  $(".btnRemoveProduct").on('click', function(e) {
    var productCard = $(this).parent().parent()
    productCard.slideUp(400, function() {
      productCard.detach().appendTo("#listedProducts")
      productCard.find(".btnAddProduct").show()
      productCard.find(".btnRemoveProduct").hide()
      productCard.show()
    })
  })

  $("#btnComplete").on('click', function(e) {
    if ($("#listedProducts .productCard").length == 0) {
      $(".alert.alert-danger").text("È necessario selezionare almeno un prodotto.")
      $(".alert.alert-danger").fadeOut()
      $(".alert.alert-danger").fadeIn()
      return
    }
    if ($("#selectedAddress").val() === '' && $("#enteredAddress").val() === '') {
      $(".alert.alert-danger").text("È necessario inserire o selezionare un indirizzo.")
      $(".alert.alert-danger").fadeOut()
      $(".alert.alert-danger").fadeIn()
      return
    }
    order = {}
    if ($("#radioSelectAddress:checked").val()) {
      // grab the address from the dropdown
      order["selectedAddress"] = $("#selectedAddress").val()
    } else {
      // grab the address from the textbox
      order["enteredAddress"] = $("#enteredAddress").val()
      order["saveAddress"] = $("#checkSaveAddress").is(":checked")
      order["enteredAddressName"] = $("#enteredAddressName").val()
    }
    // create the array for the products
    order.products = []
    $.each($("#toOrderProducts .productCard"), function() {
      product = {}
      product["id"] = $(this).data("product-id")
      product["quantity"] = $(this).find(".productQuantity").val()
      product["notes"] = $(this).find(".productNotes").val()
      order["products"].push(product)
    })
    $.post("ajax/order_placed.php", {
      data: JSON.stringify(order)
    }).done(function(response) {
      if (response.indexOf("SUCCESS") != -1) {
        $("#modalOrderPlaced").modal('show')
      } else {
        console.log(response)
        $(".alert.alert-danger").text("Errore.")
        $(".alert.alert-danger").fadeIn()
      }
    })
  })

})
</script>

<?php include("fragments/connection-end.php"); ?>
</html>
