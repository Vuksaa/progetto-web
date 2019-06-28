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
    if(!($categories=$conn->prepare("SELECT c.category_id, c.category_name
                            FROM category c
                            INNER JOIN provider_category pc
                            ON c.category_id = pc.category_id
                            WHERE pc.provider_id=?;"))) {
      echo "Prepare failed.";
    }
    if(!($categories->bind_param('i',$_SESSION['user_id']))) {
      echo "Bind failed";
    }
    if(!($categories->execute()))  {
      echo "Execute failed.";
    }
    $categories->store_result();
    $categoryName="";
    $categoryId=0;
    $categories->bind_result($categoryId,$categoryName);
  ?>

  <?php include("fragments/navbar.php"); ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-9 col-sm-6 col-md-5 col-lg-4 pt-4">
        <h4 class="pb-2">Categorie</h4>
        <ul class="list-group" id="categories">
          <button type="button" class="list-group-item list-group-item-action bg-primary text-center text-white m-0" id="btnCategoryModal" data-toggle="modal" data-target="#modalAddCategory">
            <i class="far fa-plus-square"></i>
            <span class="sr-only">Aggiungi categoria</span>
          </button>
          <?php
            while ($categories->fetch()) {
              echo '<button type="button" class="btnRemoveCategory list-group-item list-group-item-action text-center m-0" data-categoryid="'.$categoryId.'">'.$categoryName.'</button>';
            }
            $categories->close();
          ?>
        </ul>
      </div>
      <div class="col-9 col-sm-6 col-md-5 col-lg-4 pt-4">
        <h4 class="pb-2">Orari</h4>
        <div class="border p-3">
          <div class="form-group">
            <label for="openingHours" class="sr-only">Apertura (es. 08:00)</label>
            <input type="text" class="form-control" placeholder="Apertura (es. 08:00)" id="openingHours" value="<?php echo $_SESSION['opening_hours']; ?>"/>
          </div>
          <div class="form-group">
            <label for="closingHours" class="sr-only">Chiusura (es. 18:00)</label>
            <input type="text" class="form-control" placeholder="Chiusura (es. 18:00)" id="closingHours" value="<?php echo $_SESSION['closing_hours']; ?>"/>
          </div>
          <div class="alert alert-success col d-none" role="alert">
            Aggiornamento salvato
          </div>
          <div class="alert alert-danger col d-none" role="alert">
            Formato incorretto
          </div>
          <button type="button" class="btn btn-primary col" id="btnSaveHours">Salva</button>
        </div>
      </div>
    </div>
  </div>

  <?php include("fragments/footer.php"); ?>
</body>

<script>
$(function() {
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("#navbarProfile");
  var parent = element.parent();
  element.append("<span class='sr-only'>(current)</span>");
  parent.addClass("active");

  $("#btnSaveHours").on('click', function() {
    if ($("#openingHours").val() == '' || $("#closingHours").val() == '') {
      $(".alert-danger").hide()
      $(".alert-danger").removeClass("d-none")
      $(".alert-danger").fadeIn()
      $(".alert-danger").fadeOut()
      $(".alert-danger").fadeIn()
    } else {
      $.post("ajax/set_hours.php", {
        opening: $("#openingHours").val(),
        closing: $("#closingHours").val()
      }).done(function(response) {
        $(".alert-success").hide()
        $(".alert-danger").hide()
        if (response.indexOf("SUCCESS") != -1) {
          $(".alert-success").removeClass("d-none")
          $(".alert-success").fadeIn()
          $(".alert-success").fadeOut()
          $(".alert-success").fadeIn()
        } else {
        $(".alert-danger").removeClass("d-none")
        $(".alert-danger").fadeIn()
        $(".alert-danger").fadeOut()
        $(".alert-danger").fadeIn()
        }
      })
    }
  })
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
