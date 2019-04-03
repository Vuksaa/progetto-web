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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css" />
</head>

<body>
  <?php
  $servername = "localhost";
  $username = "admin";
  $password = "admin";
  $db = "tecweb";

  $conn = new mysqli($servername, $username, $password,$db);

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
      echo "i m going to add a client";
      if(!($statement=$conn->prepare("CALL client_add(?,?,?,?)"))){
        echo "prepare failed.";
      }
      if(!($statement->bind_param('ssss',$_POST['clientEmail'],$_POST['clientPassword'],$_POST['clientName'],$_POST['clientSurname']))) {
        echo "bind failed";
      }
      echo "trying to execute";
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
    }
  ?>

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-clients-tab" data-toggle="tab" href="#nav-clients" role="tab" aria-controls="nav-clients" aria-selected="true">clients</a>
      <a class="nav-item nav-link" id="nav-allergene-tab" data-toggle="tab" href="#nav-allergene" role="tab" aria-controls="nav-profile" aria-selected="false">Allergenes</a>
      <a class="nav-item nav-link" id="nav-address-tab" data-toggle="tab" href="#nav-address" role="tab" aria-controls="nav-profile" aria-selected="false">Addresses</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-clients" role="tabpanel" aria-labelledby="nav-clients-tab">
      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Email</th>
              <th scope="col">Password</th>
              <th scope="col">Name</th>
              <th scope="col">Surname</th>
            </tr>
          </thead>
          <tbody>
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
                    <button name="btnClientRemove" type="submit" class="btn btn-primary" value"clientRemove" formmethod="post" formaction="control_panel.php">
                      Remove
                    </button>
                  </td>
              </tr>
            </form>
              <?php  endwhile ?>
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
                      <button type="submit" name="btnClientAdd" class="btn btn-primary btn-lg btn-block" value="clientAdd" formmethod="post" formaction="control_panel.php">
                        Add
                      </button>
                    </td>
                  </fieldset>
                </form>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-allergene" role="tabpanel" aria-labelledby="nav-allergene-tab">
      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Allergene</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Example allergene 1</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Example allergene 2</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Example allergene 3</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">4</th>
              <form>
                <td>
                  <label for="selectAllergene">Example select allergene</label>
                  <select class="form-control" id="selectAllergene">
                    <option>Allergene 1</option>
                    <option>Allergene 2</option>
                    <option>Allergene 3</option>
                    <option>Allergene 4</option>
                    <option>Allergene 5</option>
                  </select>
                </td>
                <td>
                  <button type="button" class="btn btn-primary">
                    Add
                  </button>
                </td>
              </form>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Address</th>
              <th scope="col">Additional info</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Example address 1</td>
              <td>Example info 1</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Example address 2</td>
              <td>Example info 2</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">3</th>
              <td>Example address 3</td>
              <td>Example info 3</td>
              <td>
                <button type="button" class="btn btn-primary">
                  Remove
                </button>
              </td>
            </tr>
            <tr>
              <th scope="row">4</th>
              <form>
                <td>
                  <input type="text" class="form-control" placeholder="Address">
                </td>
                <td>
                  <input type="text" class="form-control" placeholder="Additional info">
                </td>
                <td>
                  <button type="button" class="btn btn-primary">
                    Add
                  </button>
                </td>
              </form>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</html>
