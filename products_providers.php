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
    <button type="button" class="btn btn-primary mb-3 col col-sm-auto">Nuovo prodotto</button>
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
              <label class="col-4 col-sm-3 col-lg-2 col-form-label border-right">Prezzo</label>
              <label class="col col-form-label"><?php echo $price; ?> €</label>
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
  <?php include("fragments/footer.php"); ?>
</body>

<script>
  $(function() {
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
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
