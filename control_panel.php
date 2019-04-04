<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
  <?php
  $servername = "localhost";
  $username = "root";
  $password="";
  $db = "uni_web_prod";

  $conn = new mysqli($servername, $username,$password,$db);

  if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
  }
  printf("Connected to DB successfully: %s.\n",$conn->host_info);

  if ($result = $conn->query("SELECT DATABASE()")) {
    $row = $result->fetch_row();
    printf("Default database is %s.\n", $row[0]);
    $result->close();
  }
  if(isset($_POST['btnClientAdd'])){
      echo "I'm going to add a client.";
      if(!($statement=$conn->prepare("CALL client_add(?,?,?,?)"))){
        echo "Prepare failed.";
      }
      if(!($statement->bind_param('ssss',$_POST['clientEmail'],$_POST['clientPassword'],$_POST['clientName'],$_POST['clientSurname']))) {
        echo "Bind failed";
      }
      echo "Trying to execute";
      if(!($statement->execute())){
        echo "execution failed".$statement->error;
      }

      $statement->close();
    } else if(isset($_POST['btnClientRemove'])){
      echo "submit equals remove";
      if(!($statement=$conn->prepare("CALL client_remove(?)"))){
        echo "prepare failed.";
      }
      if(!($statement->bind_param('i',$_POST['clientId']))) {
        echo "bind failed";
      }
      echo "trying to execute";
      if(!($statement->execute())){
        echo "execution failed".$statement->error;
      }
      $statement->close();
    }else if(isset($_POST['btnProviderAdd'])){
        echo "I'm going to add a provider.";
        if(!($statement=$conn->prepare("CALL provider_add(?,?,?,?,?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('ssssi',$_POST['providerName'],$_POST['providerAddress'],$_POST['providerEmail'],$_POST['providerPassword'],$_POST['selectProviderType']))) {
          echo "Bind failed.";
        }
        echo "Trying to execute.";
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }

        $statement->close();
      } else if(isset($_POST['btnProviderRemove'])){
        echo "Trying to remove a provider.";
        if(!($statement=$conn->prepare("CALL provider_remove(?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('i',$_POST['providerId']))) {
          echo "Bind failed.";
        }
        echo "Trying to execute.";
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      }else if(isset($_POST['btnProviderTypeAdd'])){
          echo "I'm going to add a provider type.";
          if(!($statement=$conn->prepare("CALL type_add(?)"))){
            echo "Prepare failed.";
          }
          if(!($statement->bind_param('s',$_POST['providerTypeName']))) {
            echo "Bind failed.";
          }
          echo "Trying to execute.";
          if(!($statement->execute())){
            echo "Execution failed: ".$statement->error;
          }

          $statement->close();
        } else if(isset($_POST['btnProviderTypeRemove'])){
          echo "Trying to remove a provider type.";
          if(!($statement=$conn->prepare("CALL type_remove(?)"))){
            echo "Prepare failed.";
          }
          if(!($statement->bind_param('i',$_POST['providerTypeId']))) {
            echo "Bind failed.";
          }
          echo "Trying to execute.";
          if(!($statement->execute())){
            echo "Execution failed: ".$statement->error;
          }
          $statement->close();
        }else if(isset($_POST['btnAllergenAdd'])){
            echo "I'm going to add an allergen.";
            if(!($statement=$conn->prepare("CALL allergen_add(?)"))){
              echo "Prepare failed.";
            }
            if(!($statement->bind_param('s',$_POST['allergenName']))) {
              echo "Bind failed.";
            }
            echo "Trying to execute.";
            if(!($statement->execute())){
              echo "Execution failed: ".$statement->error;
            }
            $statement->close();
          } else if(isset($_POST['btnAllergenRemove'])){
            echo "Trying to remove an allergen.";
            if(!($statement=$conn->prepare("CALL allergen_remove(?)"))){
              echo "Prepare failed.";
            }
            if(!($statement->bind_param('i',$_POST['allergenId']))) {
              echo "Bind failed.";
            }
            echo "Trying to execute.";
            if(!($statement->execute())){
              echo "Execution failed: ".$statement->error;
            }
            $statement->close();
          }else if(isset($_POST['btnClientAllergenAdd'])){
              echo "I'm going to add a client allergen.";
              if(!($statement=$conn->prepare("CALL client_allergen_add(?,?)"))){
                echo "Prepare failed.";
              }
              if(!($statement->bind_param('ii',$_POST['selectClientId'],$_POST['selectAllergenId']))) {
                echo "Bind failed.";
              }
              echo "Trying to execute.";
              if(!($statement->execute())){
                echo "Execution failed: ".$statement->error;
              }
              $statement->close();
            } else if(isset($_POST['btnClientAllergenRemove'])){
              echo "Trying to remove a client allergen.";
              if(!($statement=$conn->prepare("CALL client_allergen_remove(?,?)"))){
                echo "Prepare failed.";
              }
              if(!($statement->bind_param('ii',$_POST['clientId'],$_POST['allergenId']))) {
                echo "Bind failed.";
              }
              echo "Trying to execute.";
              if(!($statement->execute())){
                echo "Execution failed: ".$statement->error;
              }
              $statement->close();
            }
  ?>

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-clients-tab" data-toggle="tab" href="#nav-clients" role="tab" aria-controls="clients" aria-selected="true">Clients</a>
      <a class="nav-item nav-link" id="nav-providers-tab" data-toggle="tab" href="#nav-providers" role="tab" aria-controls="providers" aria-selected="false">Providers</a>
      <a class="nav-item nav-link" id="nav-provider-types-tab" data-toggle="tab" href="#nav-provider-types" role="tab" aria-controls="provider-types" aria-selected="false">Provider Types</a>
      <a class="nav-item nav-link" id="nav-allergens-tab" data-toggle="tab" href="#nav-allergens" role="tab" aria-controls="allergens" aria-selected="false">Allergens</a>
      <a class="nav-item nav-link" id="nav-client-allergen-tab" data-toggle="tab" href="#nav-client-allergen" role="tab" aria-controls="client-allergen" aria-selected="false">Client Allergen</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-clients" role="tabpanel" aria-labelledby="nav-clients-tab">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Email</th>
              <th scope="col">Password</th>
              <th scope="col">Name</th>
              <th scope="col">Surname</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Add Client</th>
              <form action="control_panel.php" method="post" name="client_add_form">
                <fieldset>
                  <td>
                    <label for="clientEmail" class="sr-only">Email:</label>
                    <input type="email" class="form-control" name="clientEmail" autocomplete="on" placeholder="Email.." required autofocus id="clientEmail" />
                  </td>
                  <td>
                    <label for="clientPassword" class="sr-only">Password:</label>
                    <input type="text" class="form-control" name="clientPassword" autocomplete="on" placeholder="Password.." required autofocus id="clientPassword" />
                  </td>
                  <td>
                    <label for="clientName" class="sr-only">Name:</label>
                    <input type="text" class="form-control" name="clientName" autocomplete="on" placeholder="Name.." required autofocus id="clientName" />
                  </td>
                  <td>
                    <label for="clientSurname" class="sr-only">Surname:</label>
                    <input type="text" class="form-control" name="clientSurname" autocomplete="on" placeholder="Surname.." required autofocus id="clientSurname" />
                  </td>
                  <td>
                    <button type="submit" name="btnClientAdd" class="btn btn-primary btn-lg btn-block" value="clientAdd">
                      Add
                    </button>
                  </td>
                </fieldset>
              </form>
            </tr>
            <?php
              $query = $conn->query("SELECT * FROM client");
              while ($row = mysqli_fetch_array($query)):
            ?>
            <tr>
              <form action="control_panel.php" method="post" name="client_remove_form">
                <th scope="row"><?php echo $row['client_id'];?></th>
                <?php
                  $id=$row['client_id'];
                  echo "<input type='number' name='clientId' value='".$id."' hidden>" ;
                  ?>
                <td><?php echo $row['client_email'];?></td>
                <td><?php echo $row['client_password'];?></td>
                <td><?php echo $row['client_name'];?></td>
                <td><?php echo $row['client_surname'];?></td>
                <td>
                  <button name="btnClientRemove" type="submit" class="btn btn-primary" value"clientRemove">
                    Remove
                  </button>
                </td>
            </tr>
            </form>
            <?php  endwhile ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-providers" role="tabpanel" aria-labelledby="nav-providers-tab">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Address</th>
              <th scope="col">Email</th>
              <th scope="col">Password</th>
              <th scope="col">TypeID</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Add Provider</th>
              <form action="control_panel.php" method="post" name="provider_add_form">
                <fieldset>
                  <td>
                    <label for="providerName" class="sr-only">Name:</label>
                    <input type="text" class="form-control" name="providerName" autocomplete="on" placeholder="Name.." required autofocus id="providerName" />
                  </td>
                  <td>
                    <label for="providerAddress" class="sr-only">Address:</label>
                    <input type="text" class="form-control" name="providerAddress" autocomplete="on" placeholder="Address.." required autofocus id="providerAddress" />
                  </td>
                  <td>
                    <label for="providerEmail" class="sr-only">Email:</label>
                    <input type="email" class="form-control" name="providerEmail" autocomplete="on" placeholder="Email.." required autofocus id="providerEmail" />
                  </td>
                  <td>
                    <label for="providerPassword" class="sr-only">Password:</label>
                    <input type="text" class="form-control" name="providerPassword" autocomplete="on" placeholder="Password.." required autofocus id="providerPassword" />
                  </td>
                  <td>
                    <label for="selectProviderType" class="sr-only">Select Provider Type</label>
                    <select class="form-control" name="selectProviderType" id="selectProviderType">
                    <?php
                      $query = $conn->query("SELECT * FROM type");
                      while ($row = mysqli_fetch_array($query)){
                        $id=$row['type_id'];
                        $name=$row['type_name'];
                        echo "<option value='".$id."'>".$name."</option>" ;
                      }
                    ?>
                    </select>
                  </td>
                  <td>
                    <button type="submit" name="btnProviderAdd" class="btn btn-primary btn-lg btn-block" value="providerAdd">
                      Add
                    </button>
                  </td>
                </fieldset>
              </form>
            </tr>
            <?php
              $query = $conn->query("SELECT * FROM provider");
              while ($row = mysqli_fetch_array($query)):
            ?>
            <tr>
              <form action="control_panel.php" method="post" name="provider_remove_form">
                <th scope="row"><?php echo $row['provider_id'];?></th>
                <?php
                  $id=$row['provider_id'];
                  echo "<input type='number' name='providerId' value='".$id."' hidden>" ;
                  ?>
                <td><?php echo $row['provider_name'];?></td>
                <td><?php echo $row['provider_address'];?></td>
                <td><?php echo $row['provider_email'];?></td>
                <td><?php echo $row['provider_password'];?></td>
                <td><?php echo $row['type_id'];?></td>
                <td>
                  <button name="btnProviderRemove" type="submit" class="btn btn-primary" value"providerRemove">
                    Remove
                  </button>
                </td>
            </tr>
            </form>
            <?php  endwhile ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-provider-types" role="tabpanel" aria-labelledby="nav-provider-types-tab">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Add Provider Type</th>
              <form action="control_panel.php" method="post" name="provider_type_add_form">
                <fieldset>
                  <td>
                    <label for="providerTypeName" class="sr-only">Name:</label>
                    <input type="text" class="form-control" name="providerTypeName" autocomplete="on" placeholder="Name.." required autofocus id="providerTypeName" />
                  </td>
                  <td>
                    <button type="submit" name="btnProviderTypeAdd" class="btn btn-primary btn-lg btn-block" value="providerTypeAdd">
                      Add
                    </button>
                  </td>
                </fieldset>
              </form>
            </tr>
            <?php
              $query = $conn->query("SELECT * FROM type");
              while ($row = mysqli_fetch_array($query)):
            ?>
            <tr>
              <form action="control_panel.php" method="post" name="provider_type_remove_form">
                <th scope="row"><?php echo $row['type_id'];?></th>
                <?php
                  $id=$row['type_id'];
                  echo "<input type='number' name='providerTypeId' value='".$id."' hidden>" ;
                  ?>
                <td><?php echo $row['type_name'];?></td>
                <td>
                  <button name="btnProviderTypeRemove" type="submit" class="btn btn-primary" value"providerTypeRemove">
                    Remove
                  </button>
                </td>
            </tr>
            </form>
            <?php  endwhile ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-allergens" role="tabpanel" aria-labelledby="nav-allergens-tab">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Add Allergen</th>
              <form action="control_panel.php" method="post" name="allergen_add_form">
                <fieldset>
                  <td>
                    <label for="allergenName" class="sr-only">Name:</label>
                    <input type="text" class="form-control" name="allergenName" autocomplete="on" placeholder="Name.." required autofocus id="allergenName" />
                  </td>
                  <td>
                    <button type="submit" name="btnAllergenAdd" class="btn btn-primary btn-lg btn-block" value="allergenAdd">
                      Add
                    </button>
                  </td>
                </fieldset>
              </form>
            </tr>
            <?php
              $query = $conn->query("SELECT * FROM allergen");
              while ($row = mysqli_fetch_array($query)):
            ?>
            <tr>
              <form action="control_panel.php" method="post" name="allergen_remove_form">
                <th scope="row"><?php echo $row['allergen_id'];?></th>
                <?php
                  $id=$row['allergen_id'];
                  echo "<input type='number' name='allergenId' value='".$id."' hidden>" ;
                  ?>
                <td><?php echo $row['allergen_name'];?></td>
                <td>
                  <button name="btnAllergenRemove" type="submit" class="btn btn-primary" value"allergenRemove">
                    Remove
                  </button>
                </td>
            </tr>
            </form>
            <?php  endwhile ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-client-allergen" role="tabpanel" aria-labelledby="nav-client-allergen-tab">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Client</th>
              <th scope="col">Allergen</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Add Client Allergen</th>
              <form action="control_panel.php" method="post" name="client_allergen_add_form">
                <fieldset>
                  <td>
                    <label for="selectClientId" class="sr-only">Select Client ID</label>
                    <select class="form-control" name="selectClientId" id="selectClientId">
                    <?php
                      $query = $conn->query("SELECT client_id,client_email FROM client");
                      while ($row = mysqli_fetch_array($query)){
                        $id=$row['client_id'];
                        $email=$row['client_email'];
                        echo "<option value='".$id."'>".$email."</option>" ;
                      }
                    ?>
                    </select>
                  </td>
                  <td>
                    <label for="selectAllergenId" class="sr-only">Select Allergen ID</label>
                    <select class="form-control" name="selectAllergenId" id="selectAllergenId">
                    <?php
                      $query = $conn->query("SELECT * FROM allergen");
                      while ($row = mysqli_fetch_array($query)){
                        $id=$row['allergen_id'];
                        $name=$row['allergen_name'];
                        echo "<option value='".$id."'>".$name."</option>" ;
                      }
                    ?>
                    </select>
                  </td>
                  <td>
                    <button type="submit" name="btnClientAllergenAdd" class="btn btn-primary btn-lg btn-block" value="clientAllergenAdd">
                      Add
                    </button>
                  </td>
                </fieldset>
              </form>
            </tr>
            <?php
              $query = $conn->query("SELECT client_allergen.client_id,client_allergen.allergen_id,client.client_email,allergen.allergen_name FROM (client_allergen JOIN client on client_allergen.client_id=client.client_id) JOIN allergen on client_allergen.allergen_id=allergen.allergen_id ");
              $i=1;
              while ($row = mysqli_fetch_array($query)):
            ?>
            <tr>
              <form action="control_panel.php" method="post" name="client_allergen_remove_form">
                <th scope="row"><?php echo $i++;?></th>
                <?php
                  $clientId=$row['client_id'];
                  $allergenId=$row['allergen_id'];
                  echo "<input type='number' name='clientId' value='".$clientId."' hidden>" ;
                  echo "<input type='number' name='allergenId' value='".$allergenId."' hidden>" ;
                  ?>
                <td><?php echo $row['client_email'];?></td>
                <td><?php echo $row['allergen_name'];?></td>
                <td>
                  <button name="btnClientAllergenRemove" type="submit" class="btn btn-primary" value"clientAllergenRemove">
                    Remove
                  </button>
                </td>
            </tr>
            </form>
            <?php  endwhile ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <?php
    $conn->close();
   ?>

</html>
