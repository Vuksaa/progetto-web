<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "client") {
    header('Location: profile_clients.php');
    exit();
  }
?>
<?php include("fragments/connection-begin.php"); ?>
<!DOCTYPE html>
<html lang="it">

<head>
  <?php include("fragments/head-contents.php"); ?>
  <!-- <link rel="stylesheet" type="text/css" href="styles/base.css"> -->
  <style>
    .form-inline .col-form-label {
      text-align: left;
    }
  </style>
</head>

<body>
  <?php include("fragments/navbar.php"); ?>
  <?php
    if(!($products=$conn->prepare(
      "SELECT product_id, product_name, product_price
      FROM product_by_provider
      WHERE provider_id ='".$_SESSION['user_id']."'
      AND product_active = 1
      ORDER BY product_name;"
    ))) {
      echo "Prepare failed.";
    }
    if(!($products->execute()))  {
      echo "Execute failed.";
    }
    $products->store_result();
    $name="";
    $id=0;
    $price=0;
    $products->bind_result($id, $name, $price);
    if(!($ingredients=$conn->prepare(
      "SELECT ingredient_name
      FROM uni_web_prod.ingredient_by_product
      WHERE product_id = ?;"
    ))) {
      echo "Prepare failed.";
    }
   ?>
  <div class="container mt-4 mb-4">
    <h4 class="display-4 mb-4 text-center text-sm-left">Prodotti</h4>
    <button type="button" class="btn btn-primary mb-3 col col-sm-auto" data-toggle="modal" data-target="#modalAddProduct">Nuovo prodotto</button>
    <?php
      while ($products->fetch()) {
    ?>
    <div class="card orderCard mb-3" data-productid="<?php echo $id;?>">
      <div class="card-body">
        <button type="button" class="close float-right btnDeleteProduct" data-toggle="popover" data-placement="left" data-html="true" data-trigger="focus" data-content="<a href='#' class='btn btn-danger btnConfirmDeletion'><span class='d-none productIdContainer'><?php echo $id;?></span>Elimina</a>" aria-label="Elimina">
          <span aria-hidden="true" style="color: red;">&times;</span>
        </button>
        <h5 class="card-title"><?php echo $name; ?></h5>
        <div class="card-text">
          <hr>
          <div class="p-2">
            <?php
              if(!($ingredients->bind_param('i', $id))) {
                echo "Bind failed";
              }
              if(!($ingredients->execute()))  {
                echo "Execute failed.";
              }
              $ingredients->store_result();
              $ingredient="";
              $ingredients->bind_result($ingredient);
              if ($ingredients->fetch()) {
                ?>
                <div class="row">
                  <label class="col-4 col-sm-3 col-lg-2 col-form-label border-right">Ingredienti</label>
                  <label class="col col-form-label">
                    <?php
                      echo $ingredient;
                      while ($ingredients->fetch()) {
                        echo ", ".$ingredient;
                      }
                    ?>
                  </label>
                </div>
                <?php
              }
            ?>
            <div class="row">
              <label class="col-4 col-sm-3 col-lg-2 col-form-label border-right" for="product<?php echo $id; ?>Price">Prezzo</label>
              <div class="input-group col">
                <div class="input-group-prepend">
                  <span class="input-group-text">€</span>
                </div>
                <input type="number" step="0.01" min="0" class="form-control col col-sm-6 col-md-5 col-lg-4 existingProductPrice" id="product<?php echo $id; ?>Price" value="<?php echo $price; ?>" data-product-id="<?php echo $id; ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    }
    $products->close();
    $ingredients->close();
    ?>
  </div>

  <div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modalLabelAddProduct" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelAddProduct">Aggiungi prodotto</h5>
          <button type="button" class="close" id="btnCloseModalAddProduct" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-inline">
            <label class="col-4 col-sm-3 col-form-label sr-only" for="newProductName">Nome</label>
            <input type="text" class="form-control col" id="newProductName" placeholder="Nome" required>
          </div>
          <div class="form-inline pt-2">
            <label class="col-4 col-sm-3 col-form-label sr-only" for="newProductPrice">Prezzo</label>
            <div class="input-group col pl-0 pr-0">
              <div class="input-group-prepend">
                <span class="input-group-text">€</span>
              </div>
              <input type="number" step="0.01" min="0" class="form-control" id="newProductPrice" placeholder="Prezzo" required>
            </div>
          </div>
          <hr>
          <div class="form-inline">
            <label class="col-4 col-sm-3 col-form-label sr-only" for="selectIngredientId">Seleziona ingrediente</label>
            <div class="input-group col pl-0 pr-0">
              <select class="form-control col" name="selectIngredientId" id="selectedIngredient">
                <?php
                  $query = $conn->query("SELECT * FROM ingredient ORDER BY ingredient_name");
                  while ($row = mysqli_fetch_array($query)){
                    $id = $row['ingredient_id'];
                    $name = $row['ingredient_name'];
                    echo "<option data-ingredient-id='".$id."' data-ingredient-name='".$name."'>".$name."</option>" ;
                  }
                  $query->close();
                ?>
              </select>
              <div class="input-group-append">
                <button type="button" class="btn btn-secondary" id="addIngredient"><i class="far fa-plus-square"></i></button>
              </div>
            </div>
          </div>
          <div class="pt-2" id="newProductIngredients">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddProduct" class="btn btn-primary ml-2">
            Aggiungi
          </button>
        </div>
      </div>
    </div>
  </div>
  <?php include("fragments/footer.php"); ?>
</body>

<script>
  $(function() {
    $(".existingProductPrice").on('keyup', function(e) {
      if (!$(this).parent().find(".btnUpdatePriceGroup").length) {
        var saveButton = $(`
        <div class="input-group-append btnUpdatePriceGroup">
          <button type="button" class="btn btn-secondary align-middle mb-0 mt-0" data-product-id="` + $(this).data("product-id") + `">Aggiorna</button>
        </div>`)
        saveButton.hide()
        $(this).parent().append(saveButton)
        saveButton.fadeIn(200)
        saveButton.on('click', updateProductPrice)
      }
    })

    $("#btnCloseModalAddProduct").on('click', cleanModalAddProduct)
    $("#btnAddProduct").on('click', function(e) {
      var name = $("#newProductName").val()
      var price = $("#newProductPrice").val()
      var ingredients = $.map($(".addedIngredient"), function(ingredient, index) {
        return $(ingredient).data("ingredient-id")
      })
      if(price<0||!name){
        return
      }
      $.post("ajax/add_product.php", {
        name: name,
        price: price,
        ingredients: ingredients
      }).done(function(response) {
        console.log(response)
        $("#modalAddProduct").modal('hide')
        cleanModalAddProduct()
      })
      window.location.reload(false);
    })
    $("#selectedIngredient").on('change', function(e) {
      $("#addIngredient").prop(
        'disabled',
        $(".addedIngredient[data-ingredientid=" + $("#selectedIngredient option:selected")
          .data("ingredient-id") + "]")
          .length
      )
    })
    $("#addIngredient").on('click', function(e) {
      var id = $("#selectedIngredient option:selected").data("ingredient-id")
      var name = $("#selectedIngredient option:selected").data("ingredient-name")
      var ingredient = $('<a href="#" class="addedIngredient badge badge-secondary mr-2" data-ingredient-id="' + id + '">' + name + '</a>')
      ingredient.on('click', removeIngredient)
      $("#addIngredient").prop('disabled', true)
      $("#newProductIngredients").append(ingredient)
    })
    $('body').on('click','.btnConfirmDeletion', function(e) {
      var productId = $(e.currentTarget.outerHTML).find('.productIdContainer').text()
      $.post("ajax/disable_product.php", {
        product: productId
      }).done(function(response) {
        if (response.indexOf("SUCCESS") != -1) {
          $(".orderCard[data-productid=" + productId + "]").slideUp()
        }
      })
    })
    $(".btnDeleteProduct").popover()
    /* Set navbar voice active with respective screen reader functionality */
    var element = $("#navbarProducts");
    var parent = element.parent();
    element.append( "<span class='sr-only'>(current)</span>" );
    parent.addClass("active");
  })

  function removeIngredient() {
    if ($("#selectedIngredient option:selected").data("ingredient-id") == $(this).data("ingredient-id")) {
      $("#addIngredient").prop('disabled', false)
    }
     $(this).remove()
  }

  function cleanModalAddProduct() {
    $("#newProductName").val("")
    $("#newProductPrice").val("")
    $(".addedIngredient").remove()
    $("#addIngredient").prop('disabled', false)
  }

  function updateProductPrice() {
    var price = $(this).parent().find(".existingProductPrice").val()
    var id = $(this).parent().find(".existingProductPrice").data("product-id")
    var button = $(this)
    if(price<0) {
      return
    }
    $.post("ajax/update_product_price.php", {
      price: price,
      id: id
    }).done(function(response) {
      if (response.indexOf("SUCCESS") != -1) {
        button.fadeOut(200, function() { button.remove() })
      }
    })
    window.location.reload(false);
  }
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
