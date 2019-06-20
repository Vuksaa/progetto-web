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
      <div class="container pt-3">
        <div class="form-group row p-3">
          <label for="selectAllergenId" class="sr-only">Select Allergen</label>
          <select class="form-control col-3" name="selectAllergenId" id="selectedAllergenId">
            <?php
              $query = $conn->query("SELECT * FROM allergen");
              while ($row = mysqli_fetch_array($query)){
                $id=$row['allergen_id'];
                $name=$row['allergen_name'];
                echo "<option data-allergenId='".$id."' data-allergenName='".$name."'>".$name."</option>" ;
              }
            ?>
          </select>
          <button type="submit" id="btnAddAllergen" class="btn btn-primary col-1 ml-2" value="clientAllergenAdd">
            Add
          </button>
        </div>
        <ul class="list-group" id="allergens">
          <?php
            while ($allergens->fetch()):
          ?>
          <button type="button" class="btnRemoveAllergen list-group-item list-group-item-action col-3 m-0" data-allergenId="<?php echo $allergenId ?>"><?php echo $allergenName;?></button>
          <?php
            endwhile;
            $allergens->close();
          ?>
        </ul>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
      <div class="container pt-3">
        <div class="form-group row p-3">
          <label for="clientAddressName" class="sr-only">Address Name</label>
          <input type="text" class="form-control col-2" name="addressName" autocomplete="on" placeholder="Address Name.." required autofocus id="addressName" />

          <label for="clientAddressInfo" class="sr-only">Address Street Info</label>
          <input type="text" class="form-control col-4 ml-2" name="addressInfo" autocomplete="on" placeholder="Address Street Info.." required autofocus id="addressInfo" />

          <button type="submit" id="btnAddAddress" class="btn btn-primary col-1 ml-2" value="clientAddressAdd">
            Add
          </button>
        </div>
        <ul class="list-group" id="addresses">
          <?php
            while ($addresses->fetch()):
          ?>
          <button type="button" class="btnRemoveAddress list-group-item list-group-item-action col-5 m-0" data-addressid="<?php echo $addressId; ?>"><?php echo $addressName;?>, <?php echo $addressInfo;?></button>
          <?php
            endwhile;
            $addresses->close();
          ?>
        </ul>
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
        $(newAllergen).appendTo("#allergens").on('click', removeAllergen)
      } else console.log(response)
    })
  })
  $("#btnAddAddress").on('click', function(e) {
    var addressName = $(this).parent().find("#addressName")
    var addressInfo = $(this).parent().find("#addressInfo")
    $.post("ajax/add_address.php", {
      name: addressName.val(),
      info: addressInfo.val()
    }).done(function(response) {
      if (response.indexOf("ERROR") == -1) {
        var newAddress = '<button type="button" class="btnRemoveAddress list-group-item list-group-item-action col-5 m-0" data-addressid="' + response + '">' + addressName.val() + ', ' + addressInfo.val() + '</button>'
        $(newAddress).appendTo("#addresses").on('click', removeAddress)
        $(addressName).val("")
        $(addressInfo).val("")
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
      $(self).fadeOut(200, function() {
        $(self).remove()
      })
    } else console.log(response)
  })
}

function removeAddress() {
  self = $(this)
  $.post("ajax/remove_address.php", {
    address: $(self).data("addressid")
  }).always(function(response) {
    if (response.indexOf("ERROR") == -1) {
      $(self).fadeOut(200, function() {
        $(self).remove()
      })
    } else console.log(response)
  })
}

</script>
<?php include("fragments/connection-end.php"); ?>
</html>
