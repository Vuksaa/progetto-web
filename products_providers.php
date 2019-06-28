<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "client") {
    header('Location: profile_clients.php');
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
  <?php
    if(isset($_POST['btnProductAdd'])){
      if($_POST['btnProductAdd']=="productAdd") {
          if(!($statement=$conn->prepare("CALL product_add(?,?,?,?)"))){
            echo "Prepare failed.";
          }
          if(!($statement->bind_param('ssdi',$_POST['productName'],$_POST['productDescription'],$_POST['productPrice'],$_SESSION['user_id']))) {
            echo "Bind failed.";
          }
          if(!($statement->execute())){
            echo "Execution failed: ".$statement->error;
          }
          $statement->close();
      } else if($_POST['btnProductAdd']=="productModify") {
          if(!($statement=$conn->prepare("CALL product_modify(?,?,?,?)"))){
            echo "Prepare failed.";
          }
          if(!($statement->bind_param('issd',$_POST['productId'],$_POST['productName'],$_POST['productDescription'],$_POST['productPrice']))) {
            echo "Bind failed.";
          }
          if(!($statement->execute())){
            echo "Execution failed: ".$statement->error;
          }
          $statement->close();
        }
      } else if(isset($_POST['btnProductRemove'])){
        if(!($statement=$conn->prepare("CALL product_remove(?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('i',$_POST['productId']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      }
    ?>
  <?php include("fragments/navbar.php"); ?>
  <div class="container">
    <div class="card main-card">
      <h1 class="mb-0 form-group form-inline">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProducts">
          Your products
        </button>
      </h1>
      <div id="collapseProduct" class="collapse show" aria-labelledby="headingFavouriteRestaurants">
        <div class="card-body">
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <button type="button" class="btn btn-primary" value="productAdd" data-toggle="modal" data-target="#productAddModal">Add Product</button>
          <div class="row">
            <?php
            if ($products = $conn->query("SELECT product_id, product_name, product_price, product_description
                                        FROM product
                                        WHERE provider_id = '".$_SESSION['user_id']."'")) {
            while ($productRow = $products->fetch_assoc()) {
          ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="product_remove_form">
                  <?php echo "<input type='number' name='productId' value='".$productRow['product_id']."' hidden>" ; ?>
                  <h5 class="card-title"><?php echo $productRow['product_name'] ?> </h5>
                  <p class="card-text"><?php echo $productRow['product_description'] ?></p>
                  <div class="btn-group btn-group-justified">
                    <button type="button" class="btn btn-primary inline" name="btnProductModify" value="productModify" data-toggle="modal" data-target="#productAddModal" data-id="<?php echo $productRow['product_id']?>"
                      data-name="<?php echo $productRow['product_name']?>" data-description="<?php echo $productRow['product_description']?>"
                       data-price="<?php echo $productRow['product_price']?>">
                      Modify
                    </button>
                    <button type="submit" name="btnProductRemove" class="btn btn-primary" value="productRemove">Remove</button>
                  </div>
                </form>
              </div>
            </div>
            <?php
              }
              $products->close();
            } else {
              echo "Query failed";
            }
           ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="productAddModal" tabindex="-1" role="dialog" aria-labelledby="productAddModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productAddModalLabel">Add a product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="product_add_form">
          <div class="modal-body">
            <input type="number" name="productId" value="" id="productId" hidden>
            <div class="form-group">
              <label for="productName" class="col-form-label">Name:</label>
              <input type="text" class="form-control" name="productName" id="productName" required>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Description:</label>
              <textarea class="form-control" name="productDescription" id="productDescription"></textarea>
            </div>
            <div class="form-group">
              <label for="productPrice" class="col-form-label">Price:</label>
              <input type="number" step="any" class="form-control" name="productPrice" id="productPrice" required></input>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="btnProductAdd" value="productAdd" class="btn btn-primary" id="btnProductAdd">Add product</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php include("fragments/footer.php"); ?>
</body>

<script>
//TODO REDO with ajax?
//Autocompletes Modify product modal
  $('#productAddModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var productId = button.data('id');
    var productName = button.data('name');
    var productDescription = button.data('description');
    var productPrice = button.data('price');
    var modal = $(this);
    modal.find('#productId').val(productId);
    if(button.val()=="productModify"){
      modal.find('.modal-title').text("Modify the product");
      modal.find('#productName').val(productName);
      modal.find('#productDescription').val(productDescription);
      modal.find('#productPrice').val(productPrice);
      modal.find('#btnProductAdd').text("Modify");
      modal.find('#btnProductAdd').val("productModify");
    } else {
      modal.find('.modal-title').text("Add a product");
    }
  })
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("#navbarProducts");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
