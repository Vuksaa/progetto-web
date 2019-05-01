<?php include("fragments/logged-check.php"); ?>
<?php
  if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] == "provider") {
    header('Location: home_providers.php');
    exit();
  }
?>
<?php include("fragments/connection-begin.php"); ?>
<!-- This php block is for adding favourites -->
<?php
  if(isset($_POST['btnClientProviderAdd'])){
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
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
</head>

<body>
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

  <div class="container accordion mt-4 mb-4" id="mainAccordion">
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseFavouriteRestaurants" aria-expanded="true" aria-controls="collapseFavouriteRestaurants">
          Your Favourite Restaurants
        </button>
      </h1>
      <div id="collapseFavouriteRestaurants" class="collapse show" aria-labelledby="headingFavouriteRestaurants" data-parent="#mainAccordion">
        <div class="card-body">
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <div class="row">
            <?php
              if ($favProviders = $conn->query("SELECT p.provider_id, p.provider_name, t.type_name
                                          FROM client_provider cp
                                          JOIN provider p
                                          ON cp.provider_id = p.provider_id
                                          LEFT JOIN type t
                                          ON p.type_id = t.type_id
                                          WHERE cp.client_id = '".$_SESSION['user_id']."'")) {
              while ($providerRow = $favProviders->fetch_assoc()) {
            ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="client_provider_remove_form">
                  <?php echo "<input type='number' name='providerId' value='".$providerRow['provider_id']."' hidden>" ; ?>
                  <h5 class="card-title"><?php echo $providerRow['provider_name'] ?>
                    <button type="submit" name="btnClientProviderRemove" class="btn btn-link" value="clientProviderRemove"><i class="fas fa-star"></i></button>
                  </h5>
                </form>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $providerRow['type_name'] ?></h6>
                <p class="card-text">
                  <?php
                    if ($providerCategories = $conn->query("SELECT c.category_name
                                          FROM provider p
                                          LEFT JOIN provider_category pc
                                          ON p.provider_id = pc.provider_id
                                          LEFT JOIN category c
                                          ON c.category_id = pc.category_id
                                          WHERE p.provider_id = '".$providerRow['provider_id']."'")) {
                      while ($categoryRow = $providerCategories->fetch_assoc()) {
                        echo "<span class='badge badge-pill badge-info'>".$categoryRow['category_name']."</span>";
                      }
                      $providerCategories->close();
                    }
                  ?>
                </p>
                <div class="btn-group btn-group-justified">
                  <button class="btn btn-primary inline" data-toggle="modal" data-target="#peekOnProvider">Peek</button>
                  <button class="btn btn-primary inline btn-place-order">Order</button>
                </div>
              </div>
            </div>
            <?php
                }
                $favProviders->close();
              } else {
                echo "Query failed";
              }
             ?>
          </div>
        </div>
      </div>
    </div>
    <div class="card main-card">
      <h1 class="mb-0">
        <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseAllRestaurants" aria-expanded="false" aria-controls="collapsePreparedOrders">
          Restaurants
        </button>
      </h1>
      <div id="collapseAllRestaurants" class="collapse" aria-labelledby="headingRestaurants" data-parent="#mainAccordion">
        <div class="card-body">
          <form class="form-inline card-searchbar">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
          <div class="row">
            <?php
              // TODO: use one query and separate favourite and non-favourite restaurants in php?
              if ($allProviders = $conn->query("SELECT p.provider_id, p.provider_name, t.type_name
                                          FROM provider p
                                          LEFT JOIN type t
                                          ON p.type_id = t.type_id
                                          WHERE p.provider_id NOT IN (SELECT p.provider_id
                                                                      FROM client_provider cp
                                                                      JOIN provider p
                                                                      ON cp.provider_id = p.provider_id
                                                                      WHERE cp.client_id = '".$_SESSION['user_id']."')")) {
              while ($providerRow = $allProviders->fetch_assoc()) {
            ?>
            <div class="card col-sm-3">
              <div class="card-body">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="client_provider_add_form">
                  <?php echo "<input type='number' name='providerId' value='".$providerRow['provider_id']."' hidden>" ; ?>
                  <h5 class="card-title"><?php echo $providerRow['provider_name'] ?>
                    <button type="submit" name="btnClientProviderAdd" class="btn btn-link" value="clientProviderAdd"><i class="far fa-star"></i></button>
                  </h5>
                </form>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo $providerRow['type_name'] ?></h6>
                <p class="card-text">
                  <?php
                    if ($providerCategories = $conn->query("SELECT c.category_name
                                          FROM provider p
                                          LEFT JOIN provider_category pc
                                          ON p.provider_id = pc.provider_id
                                          LEFT JOIN category c
                                          ON c.category_id = pc.category_id
                                          WHERE p.provider_id = '".$providerRow['provider_id']."'")) {
                      while ($categoryRow = $providerCategories->fetch_assoc()) {
                        echo "<span class='badge badge-pill badge-info'>".$categoryRow['category_name']."</span>";
                      }
                      $providerCategories->close();
                    }
                  ?>
                </p>
                <div class="btn-group btn-group-justified">
                  <button class="btn btn-primary inline" data-toggle="modal" data-target="#peekOnProvider">Peek</button>
                  <button class="btn btn-primary inline btn-place-order" data-provider-id="<?php echo $providerRow['provider_id']; ?>">Order</button>
                </div>
              </div>
            </div>
            <?php
                }
                $allProviders->close();
              } else {
                echo "Query failed";
              }
             ?>
          </div>
        </div>
      </div>
    </div>
  </div>
    <?php include("fragments/footer.php"); ?>
</body>

<!-- modal for peeking on a provider's main dishes/products, without entering in their profile page or in a "place order" page -->
<div id="peekOnProvider" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title place-order-header">Presented dishes</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>List of dishes/products (with their price) chosen by the provider goes here. "Dish"/"Product" flavour according to provider type?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $(".btn-place-order").click(function() {
    window.location.href = "place_order.php?provider=" + $(this).data("provider-id")
  })
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
