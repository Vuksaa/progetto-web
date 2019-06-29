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
  <?php
    // create objects for allergens and addresses here to make the html cleaner
    if(!($allergens=$conn->prepare("SELECT a.allergen_id,a.allergen_name
                            FROM allergen a JOIN client_allergen ca
                            ON a.allergen_id=ca.allergen_id
                            WHERE ca.client_id=?"))) {
      echo "Prepare failed.";
    }
    if(!($allergens->bind_param('i',$_SESSION['user_id']))) {
      echo "Bind failed";
    }
    if(!($allergens->execute()))  {
      echo "Execute failed.";
    }
    $allergens->store_result();
    $allergenName="";
    $allergenId=0;
    $allergens->bind_result($allergenId,$allergenName);
    if(!($addresses=$conn->prepare("SELECT a.address_id,a.address_name,a.address_info
                            FROM address a WHERE a.client_id=?"))) {
      echo "Prepare failed.";
    }
    if(!($addresses->bind_param('i',$_SESSION['user_id']))) {
      echo "Bind failed";
    }
    if(!($addresses->execute()))  {
      echo "Execute failed.";
    }
    $addresses->store_result();
    $addressId=0;
    $addressName="";
    $addressInfo="";
    $addresses->bind_result($addressId,$addressName,$addressInfo);
  ?>
  <?php include("fragments/navbar.php"); ?>

  <div class="container mt-4 mb-4">
    <h4 class="display-4 mb-4 text-center text-sm-left">Profilo</h4>
    <div class="row justify-content-center">
      <div class="col-9 col-sm-6 col-md-5 pt-4">
        <h4 class="pb-2">Allergeni</h4>
        <ul class="list-group" id="allergens">
          <button type="button" class="list-group-item list-group-item-action bg-primary text-center text-white m-0" data-toggle="modal" data-target="#modalAddAllergen">
            <i class="far fa-plus-square"></i>
            <span class="sr-only">Aggiungi allergene</span>
          </button>
          <?php
            while ($allergens->fetch()) {
              echo '<button type="button" class="btnRemoveAllergen list-group-item list-group-item-action text-center m-0" data-allergenId="'.$allergenId.'">'.$allergenName.'</button>';
            }
            $allergens->close();
          ?>
        </ul>
      </div>
      <div class="col-9 col-sm-6 col-md-5 pt-4">
        <h4 class="pb-2">Indirizzi</h4>
        <ul class="list-group" id="addresses">
          <button type="button" class="list-group-item list-group-item-action bg-primary text-center text-white m-0" id="btnAddressModal" data-toggle="modal" data-target="#modalAddAddress">
            <i class="far fa-plus-square"></i>
            <span class="sr-only">Aggiungi indirizzo</span>
          </button>
          <?php
            while ($addresses->fetch()) {
              echo '<button type="button" class="btnRemoveAddress list-group-item list-group-item-action text-center m-0" data-addressid="'.$addressId.'">'.$addressName.', '.$addressInfo.'</button>';
            }
            $addresses->close();
          ?>
        </ul>
      </div>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="modalAddAllergen" tabindex="-1" role="dialog" aria-labelledby="modalLabelAddAllergen" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelAddAllergen">Aggiungi allergene</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="selectAllergenId" class="sr-only">Seleziona allergene</label>
          <select class="form-control" name="selectAllergenId" id="selectedAllergenId">
            <?php
              $query = $conn->query("SELECT * FROM allergen ORDER BY allergen_name");
              while ($row = mysqli_fetch_array($query)){
                $id=$row['allergen_id'];
                $name=$row['allergen_name'];
                echo "<option data-allergenId='".$id."' data-allergenName='".$name."'>".$name."</option>" ;
              }
              $query->close();
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddAllergen" class="btn btn-primary ml-2" value="clientAllergenAdd" data-dismiss="modal">
            Aggiungi
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalAddAddress" tabindex="-1" role="dialog" aria-labelledby="modalLabelAddAddress" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelAddAddress">Aggiungi indirizzo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="clientAddressName" class="sr-only">Nome indirizzo</label>
            <input type="text" class="form-control mb-2" name="addressName" autocomplete="on" placeholder="Nome indirizzo" required autofocus id="addressName" />
            <label for="clientAddressInfo" class="sr-only">Via e civico</label>
            <input type="text" class="form-control" name="addressInfo" autocomplete="on" placeholder="Via e civico" required autofocus id="addressInfo" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddAddress" class="btn btn-primary ml-2" value="clientAddressAdd" data-dismiss="modal">
            Aggiungi
          </button>
        </div>
      </div>
    </div>
  </div>
  <?php include("fragments/footer.php"); ?>
</body>
<script type="text/javascript">
$(function() {
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("#navbarProfile");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");

  $("#btnAddAllergen").on('click', function(e) {
    var allergen = $("#selectedAllergenId :selected")
    var allergenId = $(allergen).data("allergenid")
    var allergenName = $(allergen).data("allergenname")
    $.post("ajax/add_allergen.php", {
      allergen: allergenId
    }).done(function(response) {
      if (response.indexOf("ERROR") == -1) {
        var newAllergen = '<button type="button" class="btnRemoveAllergen list-group-item list-group-item-action text-center m-0" data-allergenId="' + allergenId + '">' + allergenName + '</button>'
        $(newAllergen).hide()
        $(newAllergen).appendTo("#allergens").on('click', removeAllergen)
        $(newAllergen).slideDown(200)
      } else console.log(response)
    })
  })
  $("#btnAddAddress").on('click', function(e) {
    var addressName = $(this).parent().parent().find("#addressName")
    var addressInfo = $(this).parent().parent().find("#addressInfo")
    $.post("ajax/add_address.php", {
      name: addressName.val(),
      info: addressInfo.val()
    }).done(function(response) {
      if (response.indexOf("ERROR") == -1) {
        var newAddress = '<button type="button" class="btnRemoveAddress list-group-item list-group-item-action text-center m-0" data-addressid="' + response + '">' + addressName.val() + ', ' + addressInfo.val() + '</button>'
        $(newAddress).hide()
        $(newAddress).appendTo("#addresses").on('click', removeAddress)
        $(addressName).val("")
        $(addressInfo).val("")
        $(newAddress).slideDown(200)
      } else console.log(response)
    })
  })
  $(".btnRemoveAllergen").on('click', removeAllergen)
  $(".btnRemoveAddress").on('click', removeAddress)
})

function removeAllergen() {
  self = $(this)
  $.post("ajax/remove_allergen.php", {
    allergen: $(self).data("allergenid")
  }).done(function(response) {
    if (response.indexOf("ERROR") == -1) {
      $(self).slideUp(200, function() {
        $(self).remove()
      })
    } else console.log(response)
  })
}

function removeAddress() {
  self = $(this)
  $.post("ajax/remove_address.php", {
    address: $(self).data("addressid")
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
