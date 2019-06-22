<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "provider") {
    header('Location: profile_providers.php');
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

  <nav class="sticky-top">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-allergen-tab" data-toggle="tab" href="#nav-allergen" role="tab" aria-controls="nav-profile" aria-selected="false">Allergens</a>
      <a class="nav-item nav-link" id="nav-address-tab" data-toggle="tab" href="#nav-address" role="tab" aria-controls="nav-profile" aria-selected="false">Addresses</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-allergen" role="tabpanel" aria-labelledby="nav-allergen-tab">
      <div class="container p-3">
        <ul class="list-group" id="allergens">
          <button type="button" class="list-group-item list-group-item-action text-center col-3 m-0" data-toggle="modal" data-target="#modalAddAllergen">
            <i class="far fa-plus-square"></i>
          </button>
          <?php
            while ($allergens->fetch()) {
              echo '<button type="button" class="btnRemoveAllergen list-group-item list-group-item-action col-3 m-0" data-allergenId="'.$allergenId.'">'.$allergenName.'</button>';
            }
            $allergens->close();
          ?>
        </ul>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
      <div class="container pt-3">
        <ul class="list-group" id="addresses">
          <button type="button" class="list-group-item list-group-item-action text-center col-5 m-0" id="btnAddressModal" data-toggle="modal" data-target="#modalAddAddress">
            <i class="far fa-plus-square"></i>
          </button>
          <?php
            while ($addresses->fetch()) {
              echo '<button type="button" class="btnRemoveAddress list-group-item list-group-item-action col-5 m-0" data-addressid="'.$addressId.'">'.$addressName.', '.$addressInfo.'</button>';
            }
            $addresses->close();
          ?>
        </ul>
      </div>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="modalAddAllergen" tabindex="-1" role="dialog" aria-labelledby="modalLabelAddAllergen" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelAddAllergen">Add Allergen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="selectAllergenId" class="sr-only">Select Allergen</label>
          <select class="form-control" name="selectAllergenId" id="selectedAllergenId">
            <?php
              $query = $conn->query("SELECT * FROM allergen");
              while ($row = mysqli_fetch_array($query)){
                $id=$row['allergen_id'];
                $name=$row['allergen_name'];
                echo "<option data-allergenId='".$id."' data-allergenName='".$name."'>".$name."</option>" ;
              }
            ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddAllergen" class="btn btn-primary col-2 ml-2" value="clientAllergenAdd" data-dismiss="modal">
            Add
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalAddAddress" tabindex="-1" role="dialog" aria-labelledby="modalLabelAddAddress" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabelAddAddress">Add Address</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="clientAddressName" class="sr-only">Address Name</label>
            <input type="text" class="form-control mb-2" name="addressName" autocomplete="on" placeholder="Address Name.." required autofocus id="addressName" />
            <label for="clientAddressInfo" class="sr-only">Address Street Info</label>
            <input type="text" class="form-control" name="addressInfo" autocomplete="on" placeholder="Address Street Info.." required autofocus id="addressInfo" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" id="btnAddAddress" class="btn btn-primary col-2 ml-2" value="clientAddressAdd" data-dismiss="modal">
            Add
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
  var element = $("nav div ul li a:contains('Profile')");
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
        var newAllergen = '<button type="button" class="btnRemoveAllergen list-group-item list-group-item-action col-3 m-0" data-allergenId="' + allergenId + '">' + allergenName + '</button>'
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
        var newAddress = '<button type="button" class="btnRemoveAddress list-group-item list-group-item-action col-5 m-0" data-addressid="' + response + '">' + addressName.val() + ', ' + addressInfo.val() + '</button>'
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
