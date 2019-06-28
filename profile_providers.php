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
  var element = $("#navbarProfile");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
