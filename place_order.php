<?php
  session_start();
  if (!isset($_SESSION['logged']) || $_SESSION['logged'] == FALSE) {
    header('Location: login.php');
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Project</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css" />
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
    }if(isset($_POST['btnClientProviderAdd'])){
        if(!($statement=$conn->prepare("INSERT INTO client_provider(client_provider.client_id,client_provider.provider_id)
                                VALUES (?,?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('ii',$_SESSION['user_id'],$_POST['providerId']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      } else if(isset($_POST['btnClientProviderRemove'])){
        if(!($statement=$conn->prepare("DELETE FROM client_provider
                                WHERE client_provider.client_id=? AND client_provider.provider_id=?"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('ii',$_SESSION['user_id'],$_POST['providerId']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      }
  ?>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="home_clients.php">
      <img src="res/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
      Project
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="home_clients.php"><i class="fas fa-home"></i> Home<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile_clients.php"><i class="fas fa-user"></i> Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders_clients.php"><i class="fas fa-book"></i> Orders</a>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <div class="navbar-text">Welcome, <?php echo $_SESSION['user_name']; ?>. Bon appétit!</div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container pt-4 pb-4">
    <div class="card">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <h5 class="card-title">Menu</h5>
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </li>
        <li class="list-group-item">
          <h5 class="card-title">Order review</h5>
        </li>
        <li class="list-group-item">
          <h5 class="card-title">Address and confirmation</h5>
            <form class="pt-2">
              <div class="form-group col-md-4">
                <div class="custom-control custom-radio">
                  <input type="radio" id="radioSelectAddress" name="customRadio" class="custom-control-input" checked="true">
                  <label class="custom-control-label" for="customRadio1">Select address</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="radioEnterAddress" name="customRadio" class="custom-control-input">
                  <label class="custom-control-label" for="customRadio2">Enter address</label>
                </div>
              </div>
              <!-- Hide this div if radioSelectAddress is unchecked -->
              <div class="form-group col-md-4" id="formSelectAddress">
                <select class="custom-select" required>
                  <option value="">Select address</option>
                  <option value="1">Address 1</option>
                  <option value="2">Address 2</option>
                  <option value="3">Address 3</option>
                </select>
              </div>
              <!-- Hide this div if radioEnterAddress is unchecked -->
              <div class="form-group col-md-4" id="formEnterAddress">
                <label for="enteredAddress">Address</label>
                <input type="text" class="form-control" id="enteredAddress" placeholder="Address" required>
                <!-- TODO: align with the other forms (why is it 3px to the left compared to other elements??) -->
                <div class="form-check">
                  <input type="checkbox" class="custom-control-input" value="" id="checkSaveAddress" required>
                  <label class="custom-control-label" for="checkSaveAddress">
                    Save this address
                  </label>
                </div>
              </div>

            <!-- Selected address here (empty if there is no address selected) -->
            <h6 class="pt-3" id="addressSelected">Selected address (maybe remove this altogether)</h6>
          </form>
        </li>
      </ul>
    </div>
  </div>

  <?php
    $conn->close();
  ?>
  <footer class="footer">
    <div class="container">
      <p class="text-muted">Dummy Copyrights</p>
    </div>
  </footer>
</body>

</html>
