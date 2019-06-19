<?php include("fragments/logged-check.php"); ?>
<?php
  if ($_SESSION['user_type'] == "provider") {
    header('Location: home_providers.php');
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
  <?php include("fragments/navbar.php"); ?>
  <div class="container mt-4 mb-4">
    <h3 class="pb-2">Provider list</h3>
    <div class="container accordion mt-4 mb-4" id="mainAccordion">
      <div class="card main-card">
        <h1 class="mb-0">
          <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseFavouriteRestaurants" aria-expanded="true" aria-controls="collapseFavouriteRestaurants">
            Your Favourite Restaurants
          </button>
        </h1>
        <div id="collapseFavouriteRestaurants" class="collapse show" aria-labelledby="headingFavouriteRestaurants" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card-searchbar col-5">
              <input class="form-control mr-sm-2" id="searchFavourites" type="search" placeholder="Search" aria-label="Search Favourites">
            </div>
            <div class="row" id="favouriteProviders">
              <?php
                if ($favProviders = $conn->query(
                  "SELECT p.provider_id, p.provider_name, t.type_name
                  FROM client_provider cp
                  JOIN provider p
                  ON cp.provider_id = p.provider_id
                  LEFT JOIN type t
                  ON p.type_id = t.type_id
                  WHERE cp.client_id = '".$_SESSION['user_id']."'"
                )) {
                  while ($providerRow = $favProviders->fetch_assoc()) {
              ?>
              <div class="card col-sm-3 providerCard favouriteProvider" data-provider-id="<?php echo $providerRow['provider_id']; ?>">
                <div class="card-body">
                  <div class="float-right">
                    <button name="addFavourite" class="btn btn-link"><i class="far fa-star"></i></button>
                    <button name="removeFavourite" class="btn btn-link"><i class="fas fa-star"></i></button>
                  </div>
                  <h5 class="card-title"><?php echo $providerRow['provider_name'] ?></h5>
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
          <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseAllRestaurants" aria-expanded="false" aria-controls="collapseAllRestaurants">
            Restaurants
          </button>
        </h1>
        <div id="collapseAllRestaurants" class="collapse" aria-labelledby="headingRestaurants" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card-searchbar col-5">
              <input class="form-control mr-sm-2" id="searchListed" type="search" placeholder="Search" aria-label="Search Listed">
            </div>
            <div class="row" id="listedProviders">
              <?php
                // TODO: use one query and separate favourite and non-favourite restaurants in php?
                if ($allProviders = $conn->query(
                  "SELECT p.provider_id, p.provider_name, t.type_name
                  FROM provider p
                  LEFT JOIN type t
                  ON p.type_id = t.type_id
                  WHERE p.provider_id NOT IN (
                    SELECT p.provider_id
                    FROM client_provider cp
                    JOIN provider p
                    ON cp.provider_id = p.provider_id
                    WHERE cp.client_id = '".$_SESSION['user_id']."'
                  )"
                )) {
                  while ($providerRow = $allProviders->fetch_assoc()) {
              ?>
              <div class="card col-sm-3 providerCard listedProvider" data-provider-id="<?php echo $providerRow['provider_id']; ?>">
                <div class="card-body">
                  <div class="float-right">
                    <button name="addFavourite" class="btn btn-link"><i class="far fa-star"></i></button>
                    <button name="removeFavourite" class="btn btn-link"><i class="fas fa-star"></i></button>
                  </div>
                  <h5 class="card-title"><?php echo $providerRow['provider_name'] ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted"><?php echo $providerRow['type_name'] ?></h6>
                  <p class="card-text">
                    <?php
                      if ($providerCategories = $conn->query(
                        "SELECT c.category_name
                        FROM provider p
                        LEFT JOIN provider_category pc
                        ON p.provider_id = pc.provider_id
                        LEFT JOIN category c
                        ON c.category_id = pc.category_id
                        WHERE p.provider_id = '".$providerRow['provider_id']."'"
                      )) {
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
  $("#searchFavourites").on('keyup', function(e) {
    var inputed = $(this).val().toLowerCase()
    var items = $(".favouriteProvider")
    // show all listed product if the searchbar is blank
    if (inputed == "") {
      items.show()
      return
    }
    $.each(items, function() {
      var providerName = $(this).find(".card-title").text().toLowerCase()
      // true if the text inputed in the searchbar is not contained in the product's name
      if (providerName.indexOf(inputed) == -1) {
        $(this).hide()
      } else {
        $(this).show()
      }
    })
  })
  $("#searchListed").on('keyup', function(e) {
    var inputed = $(this).val().toLowerCase()
    var items = $(".listedProvider")
    // show all listed product if the searchbar is blank
    if (inputed == "") {
      items.show()
      return
    }
    $.each(items, function() {
      var providerName = $(this).find(".card-title").text().toLowerCase()
      // true if the text inputed in the searchbar is not contained in the product's name
      if (providerName.indexOf(inputed) == -1) {
        $(this).hide()
      } else {
        $(this).show()
      }
    })
  })


  $(".btn-place-order").click(function() {
    window.location.href = "place_order.php?provider=" + $(this).parent().parent().parent().data("provider-id")
  })
  /* Set navbar voice active with respective screen reader functionality */
  var element = $("nav div ul li a:contains('Home')");
  var parent = element.parent();
  element.append( "<span class='sr-only'>(current)</span>" );
  parent.addClass("active");

  $("#favouriteProviders button[name='addFavourite']").hide()
  $("#listedProviders button[name='removeFavourite']").hide()

  $("button[name='addFavourite']").on('click', function() {
    var providerCard = $(this).parent().parent().parent()
    var thisButton = $(this)
    $.post("ajax/add_favourite_provider.php", {
      providerId: providerCard.data("provider-id")
    }).done(function(response) {
      if (response == "SUCCESS") {
        providerCard.find("button[name='removeFavourite']").show()
        thisButton.hide()
        providerCard.fadeOut(250, function() {
          providerCard.detach().appendTo("#favouriteProviders")
          providerCard.show()
          // if (providerCard.find(".card-title").text().toLowerCase().indexOf($("#favouriteProviders").val().toLowerCase()) == -1) {
          //   providerCard.show()
          // }
        })
      }
    })
  })
  $("button[name='removeFavourite']").on('click', function() {
    var providerCard = $(this).parent().parent().parent()
    var thisButton = $(this)
    $.post("ajax/remove_favourite_provider.php", {
      providerId: providerCard.data("provider-id")
    }).done(function(response) {
      if (response == "SUCCESS") {
        providerCard.find("button[name='addFavourite']").show()
        thisButton.hide()
        providerCard.fadeOut(250, function() {
          providerCard.detach().appendTo("#listedProviders")
          providerCard.show()
          // if (providerCard.find(".card-title").text().toLowerCase().indexOf($("#listedProviders").val().toLowerCase()) == -1) {
          //   providerCard.show()
          // }
        })
      }
    })
  })
})
</script>
<?php include("fragments/connection-end.php"); ?>
</html>
