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
  <?php
    if(!($categories=$conn->prepare("SELECT c.category_id, c.category_name
                            FROM category c
                            INNER JOIN provider_category pc
                            ON c.category_id = pc.category_id
                            WHERE pc.provider_id=?
                            ORDER BY c.category_name;"))) {
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

  <div class="container mt-4 mb-4">
    <h1 class="display-4 mb-4 text-center text-sm-left">Profilo</h1>
    <div class="row justify-content-center">
      <section class="col-9 col-sm-6 col-md-5 pt-4">
        <h2 class="pb-2">Orari</h2>
        <div class="border p-3">
          <div class="form-group">
            <label for="openingHours" class="sr-only">Apertura (es. 08:00)</label>
            <input type="time" class="form-control" placeholder="Apertura (es. 08:00)" id="openingHours" value="<?php echo $_SESSION['opening_hours']; ?>" />
          </div>
          <div class="form-group">
            <label for="closingHours" class="sr-only">Chiusura (es. 18:00)</label>
            <input type="time" class="form-control" placeholder="Chiusura (es. 18:00)" id="closingHours" value="<?php echo $_SESSION['closing_hours']; ?>" />
          </div>
          <div class="alert alert-success col d-none" role="alert">
            Aggiornamento salvato
          </div>
          <div class="alert alert-danger col d-none" role="alert">
            Formato incorretto
          </div>
          <button type="button" class="btn btn-primary col" id="btnSaveHours">Salva</button>
        </div>
      </section>
      <section class="col-9 col-sm-6 col-md-5 pt-4">
        <h2 class="pb-2">Categorie</h2>
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
      </section>
    </div>
  </div>
  <!-- Modals -->
  <div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog" aria-labelledby="modalLabelAddCategory" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelAddCategory">Aggiungi categoria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="selectCategoryId" class="sr-only">Seleziona categoria</label>
          <select class="form-control" name="selectCategoryId" id="selectedCategoryId">
            <?php
              $query = $conn->query("SELECT * FROM category ORDER BY category_name");
              while ($row = mysqli_fetch_array($query)){
                $id=$row['category_id'];
                $name=$row['category_name'];
                echo "<option data-categoryId='".$id."' data-categoryName='".$name."'>".$name."</option>" ;
              }
              $query->close();
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddCategory" class="btn btn-primary ml-2" value="clientCategoryAdd" data-dismiss="modal">
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
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("#navbarProfile");
  var parent = element.parent();
  element.append("<span class='sr-only'>(current)</span>");
  parent.addClass("active");

  $("#btnSaveHours").on('click', function() {
    if (!$("#openingHours")[0].checkValidity() || !$("#closingHours")[0].checkValidity()) {
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

  $("#btnAddCategory").on('click', function(e) {
    var category = $("#selectedCategoryId :selected")
    var categoryId = $(category).data("categoryid")
    var categoryName = $(category).data("categoryname")
    $.post("ajax/add_category.php", {
      category: categoryId
    }).done(function(response) {
      if (response.indexOf("ERROR") == -1) {
        var newCategory = '<button type="button" class="btnRemoveCategory list-group-item list-group-item-action text-center m-0" data-categoryId="' + categoryId + '">' + categoryName + '</button>'
        $(newCategory).hide()
        $(newCategory).appendTo("#categories").on('click', removeCategory)
        $(newCategory).slideDown(200)
      } else console.log(response)
    })
  })
  $(".btnRemoveCategory").on('click', removeCategory)
})

function removeCategory() {
  self = $(this)
  $.post("ajax/remove_category.php", {
    category: $(self).data("categoryid")
  }).done(function(response) {
    if (response.indexOf("ERROR") == -1) {
      $(self).slideUp(200, function() {
        $(self).remove()
      })
    } else console.log(response)
  })
}
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
