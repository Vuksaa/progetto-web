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
  if(isset($_POST['btnClientAllergenRemove'])){
      if(!($statement=$conn->prepare("CALL client_allergen_remove(?,?)"))){
        echo "Prepare failed.";
      }
      if(!($statement->bind_param('ii',$_SESSION['user_id'],$_POST['allergenId']))) {
        echo "Bind failed.";
      }
      if(!($statement->execute())){
        echo "Execution failed: ".$statement->error;
      }
      $statement->close();
    } else if(isset($_POST['btnClientAddressAdd'])){
        if(!($statement=$conn->prepare("CALL address_add(?,?,?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('ssi',$_POST['addressName'],$_POST['addressInfo'],$_SESSION['user_id']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      } else if(isset($_POST['btnClientAddressRemove'])){
        if(!($statement=$conn->prepare("CALL address_remove(?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('i',$_POST['addressId']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      }
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
        <div class="form-group row pb-2">
          <label for="selectAllergenId" class="sr-only">Select Allergen</label>
          <select class="form-control col-3 m-2" name="selectAllergenId" id="selectedAllergenId">
            <?php
              $query = $conn->query("SELECT * FROM allergen");
              while ($row = mysqli_fetch_array($query)){
                $id=$row['allergen_id'];
                $name=$row['allergen_name'];
                echo "<option data-allergenId='".$id."' data-allergenName='".$name."'>".$name."</option>" ;
              }
            ?>
          </select>
          <button type="submit" id="btnAddAllergen" class="btn btn-primary col-2 m-2" value="clientAllergenAdd">
            Add
          </button>
        </div>
        <ul class="list-group" id="allergensList">
          <?php
          if(!($statement=$conn->prepare("SELECT a.allergen_id,a.allergen_name
                                  FROM allergen a JOIN client_allergen ca
                                  ON a.allergen_id=ca.allergen_id
                                  WHERE ca.client_id=?"))) {
            echo "Prepare failed.";
          }
          if(!($statement->bind_param('i',$_SESSION['user_id']))) {
            echo "Bind failed";
          }
          if(!($statement->execute()))  {
            echo "Execute failed.";
          }
          $statement->store_result();
          $allergenName="";
          $allergenId=0;
          $statement->bind_result($allergenId,$allergenName);
          $i=1;
          while ($statement->fetch()):
          ?>
          <button type="button" class="list-group-item list-group-item-action col-5 m-0" data-allergenId="<?php echo $allergenId ?>"><?php echo $allergenName;?></button>
          <?php
            endwhile;
            $statement->close();
          ?>
        </ul>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Address Name</th>
              <th scope="col">Address info</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Add Address</th>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="address_add_form">
                <fieldset>
                  <?php echo "<input type='number' name='clientId' value='".$_SESSION['user_id']."' hidden>" ; ?>
                  <td>
                    <label for="clientAddressName" class="sr-only">Address Name:</label>
                    <input type="text" class="form-control" name="addressName" autocomplete="on" placeholder="Address Name.." required autofocus id="addressName" />
                  </td>
                  <td>
                    <label for="clientAddressInfo" class="sr-only">Address Info:</label>
                    <input type="text" class="form-control" name="addressInfo" autocomplete="on" placeholder="Address Info.." required autofocus id="addressInfo" />
                  </td>
                  <td>
                    <button type="submit" name="btnClientAddressAdd" class="btn btn-primary btn-block" value="clientAddressAdd">
                      Add
                    </button>
                  </td>
                </fieldset>
              </form>
            </tr>
            <?php
            if(!($statement=$conn->prepare("SELECT a.address_id,a.address_name,a.address_info
                                    FROM address a WHERE a.client_id=?"))) {
              echo "Prepare failed.";
            }
            if(!($statement->bind_param('i',$_SESSION['user_id']))) {
              echo "Bind failed";
            }
            if(!($statement->execute()))  {
              echo "Execute failed.";
            }
            $statement->store_result();
            $addressId=0;
            $addressName="";
            $addressInfo="";
            $statement->bind_result($addressId,$addressName,$addressInfo);
            $i=1;
            while ($statement->fetch()):
            ?>
            <tr>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="address_remove_form">
                <th scope="row"><?php echo $i++;?></th>
                <?php
                  echo "<input type='number' name='addressId' value='".$addressId."' hidden>" ;
                ?>
                <td><?php echo $addressName;?></td>
                <td><?php echo $addressInfo;?></td>
                <td>
                  <button name="btnClientAddressRemove" type="submit" class="btn btn-primary btn-block" value"clientAddressRemove">
                    Remove
                  </button>
                </td>
              </form>
            </tr>
            <?php
              endwhile;
              $statement->close();
            ?>
          </tbody>
        </table>
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
      if (response == "OK") {
        $("#allergensList").append('<button type="button" class="list-group-item list-group-item-action col-5 m-0" data-allergenId="' + allergenId + '">' + allergenName + '</button>')
      }
    })
  })
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
