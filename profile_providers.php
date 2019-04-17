<?php
  session_start();
  if (!isset($_SESSION['logged']) || $_SESSION['logged'] == FALSE) {
    header('Location: login.php');
    exit();
  } else if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "client") {
    header('Location: profile_clients.php');
    exit();
  }
?>
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
  $username = "root";
  $password="";
  $db = "uni_web_prod";
  $conn = new mysqli($servername, $username,$password,$db);
  if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
  }
  if(isset($_POST['btnProductAdd'])){
    if($_POST['btnProductAdd']=="productAdd") {
        if(!($statement=$conn->prepare("CALL product_add(?,?,?,?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('ssdi',$_POST['productName'],$_POST['productDescription'],$_POST['productPrice'],$_SESSION['user_id']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
    } else if($_POST['btnProductAdd']=="productModify") {
        if(!($statement=$conn->prepare("CALL product_modify(?,?,?,?)"))){
          echo "Prepare failed.";
        }
        if(!($statement->bind_param('issd',$_POST['productId'],$_POST['productName'],$_POST['productDescription'],$_POST['productPrice']))) {
          echo "Bind failed.";
        }
        if(!($statement->execute())){
          echo "Execution failed: ".$statement->error;
        }
        $statement->close();
      }
    } else if(isset($_POST['btnProductRemove'])){
      if(!($statement=$conn->prepare("CALL product_remove(?)"))){
        echo "Prepare failed.";
      }
      if(!($statement->bind_param('i',$_POST['productId']))) {
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
        <li class="nav-item">
          <a class="nav-link" href="home_providers.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="profile_providers.php"><i class="fas fa-user"></i> Profile<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="orders_clients.php"><i class="fas fa-book"></i> Orders</a>
        </li>
      </ul>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <div class="navbar-text">Welcome, <?php echo $_SESSION['user_name']; ?>. placeholder</div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
      </ul>
    </div>
  </nav>

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
      <a class="nav-item nav-link" id="nav-product-tab" data-toggle="tab" href="#nav-product" role="tab" aria-controls="nav-profile" aria-selected="false">Products</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
    </div>
    <div class="tab-pane fade" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab">
      <div class="container">
        <div class="card main-card">
          <h1 class="mb-0 form-group form-inline">
            <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseProduct" aria-expanded="true" aria-controls="collapseProducts">
              Your products
            </button>
          </h1>
          <div id="collapseProduct" class="collapse show" aria-labelledby="headingFavouriteRestaurants">
            <div class="card-body">
              <form class="form-inline card-searchbar">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form>
              <button type="button" class="btn btn-primary" value="productAdd" data-toggle="modal" data-target="#productAddModal">Add Product</button>
              <div class="row">
                <?php
                if ($products = $conn->query("SELECT product_id, product_name, product_price, product_description
                                            FROM product
                                            WHERE provider_id = '".$_SESSION['user_id']."'")) {
                while ($productRow = $products->fetch_assoc()) {
              ?>
                <div class="card col-sm-3">
                  <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="product_remove_form">
                      <?php echo "<input type='number' name='productId' value='".$productRow['product_id']."' hidden>" ; ?>
                      <h5 class="card-title"><?php echo $productRow['product_name'] ?> </h5>
                      <p class="card-text"><?php echo $productRow['product_description'] ?></p>
                      <div class="btn-group btn-group-justified">
                        <button type="button" class="btn btn-primary inline" name="btnProductMpdify" value="productModify" data-toggle="modal" data-target="#productAddModal" data-id="<?php echo $productRow['product_id']?>"
                          data-name="<?php echo $productRow['product_name']?>" data-description="<?php echo $productRow['product_description']?>"
                           data-price="<?php echo $productRow['product_price']?>">
                          Modify
                        </button>
                        <button type="submit" name="btnProductRemove" class="btn btn-primary" value="productRemove">Remove</button>
                      </div>
                    </form>
                  </div>
                </div>
                <?php
                  }
                  $products->close();
                } else {
                  echo "Query failed";
                }
               ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="productAddModal" tabindex="-1" role="dialog" aria-labelledby="productAddModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productAddModalLabel">Add a product</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="product_add_form">
          <div class="modal-body">
            <input type="number" name="productId" value="" id="productId" hidden>
            <div class="form-group">
              <label for="productName" class="col-form-label">Name:</label>
              <input type="text" class="form-control" name="productName" id="productName" required>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Description:</label>
              <textarea class="form-control" name="productDescription" id="productDescription"></textarea>
            </div>
            <div class="form-group">
              <label for="productPrice" class="col-form-label">Price:</label>
              <input type="number" step="any" class="form-control" name="productPrice" id="productPrice" required></input>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="btnProductAdd" value="productAdd" class="btn btn-primary" id="btnProductAdd">Add product</button>
          </div>
        </form>
      </div>
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

<script>
//REDO with ajax?
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
    } else {
      modal.find('.modal-title').text("Add a product");
    }
    modal.find('#productName').val(productName);
    modal.find('#productDescription').val(productDescription);
    modal.find('#productPrice').val(productPrice);
    modal.find('#btnProductAdd').text("Modify");
    modal.find('#btnProductAdd').val("productModify");
  })
</script>

</html>
