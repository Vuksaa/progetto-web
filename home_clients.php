<?php include("fragments/logged-check.php"); ?>
<?php
  if ($_SESSION['user_type'] === "provider") {
    header('Location: home_providers.php');
    exit();
  }
?>
<?php include("fragments/connection-begin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("fragments/head-contents.php"); ?>
  <link rel="stylesheet" type="text/css" href="styles/fluid-grids.css">
  <link rel="stylesheet" type="text/css" href="styles/base.css">
</head>

<body>
  <?php include("fragments/navbar.php"); ?>

  <div class="container mt-4 mb-4">
    <h4 class="display-4 pb-2">Provider list</h4>
    <button type="button" class="btn btn-outline-info col-sm-2 col-m-2" id="btnFilters" data-toggle="modal" data-target="#modalFilters" aria-label="Click to open filter menu modal">
      Filters <span id="filterState" style="color: black;">(no filters)</span>
    </button>
    <div class="container accordion mt-4 mb-4" id="mainAccordion">
      <div class="card main-card">
        <h1 class="mb-0" id="headingFavouriteProviders">
          <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseFavouriteProviders" aria-expanded="true" aria-controls="collapseFavouriteProviders">
            Your Favourite Providers
          </button>
        </h1>
        <div id="collapseFavouriteProviders" class="collapse show" aria-labelledby="headingFavouriteProviders" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card-searchbar">
              <label for="searchFavourites" class="sr-only">Search in favourite providers:</label>
              <input class="form-control mr-sm-2" id="searchFavourites" type="search" placeholder="Search">
            </div>
            <div class="row" id="favouriteProviders">
              <?php
                if ($favProviders = $conn->query(
                  "SELECT p.provider_id, p.provider_name, t.type_id, t.type_name
                  FROM client_provider cp
                  JOIN provider p
                  ON cp.provider_id = p.provider_id
                  LEFT JOIN type t
                  ON p.type_id = t.type_id
                  WHERE cp.client_id = '".$_SESSION['user_id']."'
                  ORDER BY p.provider_name"
                )) {
                  while ($providerRow = $favProviders->fetch_assoc()) {
              ?>
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pb-2 provider favouriteProvider" data-provider-id="<?php echo $providerRow['provider_id']; ?>">
                <div class="card">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $providerRow['provider_name'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted providerType" data-id="<?php echo $providerRow['type_id']; ?>"><?php echo $providerRow['type_name'] ?></h6>
                    <p class="card-text">
                      <?php
                        if ($providerCategories = $conn->query("SELECT c.category_id, c.category_name
                                              FROM provider p
                                              LEFT JOIN provider_category pc
                                              ON p.provider_id = pc.provider_id
                                              LEFT JOIN category c
                                              ON c.category_id = pc.category_id
                                              WHERE p.provider_id = '".$providerRow['provider_id']."'
                                              ORDER BY c.category_name")) {
                          while ($categoryRow = $providerCategories->fetch_assoc()) {
                            echo "<span class='badge badge-pill badge-info providerCategory mr-1' data-id='".$categoryRow['category_id']."'>".$categoryRow['category_name']."</span>";
                          }
                          $providerCategories->close();
                        }
                      ?>
                    </p>
                    <div class="btn-group mt-auto" role="group" aria-labelledby="Provider-related actions">
                      <button class="btn btn-primary inline btn-place-order border-right">Order</button>
                      <button class="btn btn-primary inline border-left" name="removeFavourite"><span class="sr-only">Remove Favourite</span><i class="fas fa-star" aria-hidden="true"></i></button>
                    </div>
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
        <h1 class="mb-0" id="headingProviders">
          <button class="btn btn-secondary btn-lg btn-block active" data-toggle="collapse" data-target="#collapseAllProviders" aria-expanded="false" aria-controls="collapseAllProviders">
            Providers
          </button>
        </h1>
        <div id="collapseAllProviders" class="collapse" aria-labelledby="headingProviders" data-parent="#mainAccordion">
          <div class="card-body">
            <div class="card-searchbar">
              <label for="searchListed" class="sr-only">Search in listed providers:</label>
              <input class="form-control mr-sm-2" id="searchListed" type="search" placeholder="Search">
            </div>
            <div class="row" id="listedProviders">
              <?php
                // TODO: use one query and separate favourite and non-favourite restaurants in php?
                if ($allProviders = $conn->query(
                  "SELECT p.provider_id, p.provider_name, t.type_id, t.type_name
                  FROM provider p
                  LEFT JOIN type t
                  ON p.type_id = t.type_id
                  WHERE p.provider_id NOT IN (
                    SELECT p.provider_id
                    FROM client_provider cp
                    JOIN provider p
                    ON cp.provider_id = p.provider_id
                    WHERE cp.client_id = '".$_SESSION['user_id']."'
                  )
                  ORDER BY p.provider_name"
                )) {
                  while ($providerRow = $allProviders->fetch_assoc()) {
              ?>
              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 pb-2 provider listedProvider" data-provider-id="<?php echo $providerRow['provider_id']; ?>">
                <div class="card">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo $providerRow['provider_name'] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted providerType" data-id="<?php echo $providerRow['type_id']; ?>"><?php echo $providerRow['type_name'] ?></h6>
                    <p class="card-text">
                      <?php
                        if ($providerCategories = $conn->query(
                          "SELECT c.category_id, c.category_name
                          FROM provider p
                          LEFT JOIN provider_category pc
                          ON p.provider_id = pc.provider_id
                          LEFT JOIN category c
                          ON c.category_id = pc.category_id
                          WHERE p.provider_id = '".$providerRow['provider_id']."'
                          ORDER BY c.category_name"
                        )) {
                          while ($categoryRow = $providerCategories->fetch_assoc()) {
                            echo "<span class='badge badge-pill badge-info providerCategory mr-1' data-id='".$categoryRow['category_id']."'>".$categoryRow['category_name']."</span>";
                          }
                          $providerCategories->close();
                        }
                      ?>
                    </p>
                    <div class="btn-group mt-auto" role="group" aria-labelledby="Provider-related actions">
                      <button class="btn btn-primary inline btn-place-order border-right">Order</button>
                      <button class="btn btn-primary inline border-left" name="addFavourite"><span class="sr-only">Add Favourite</span><i class="far fa-star" aria-hidden="true"></i></button>
                    </div>
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

<!-- Modal for filters -->
<div class="modal fade" id="modalFilters" tabindex="-1" role="dialog" aria-labelledby="modalLabelFilters" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ml-2 mr-2" id="modalLabelFilters">Filters</h4>
        <button type="button" class="close btnSaveFilters" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ml-2 mr-2">
        <div class="pb-2 mb-3 border-bottom">
          <div class="pb-2 pt-2 custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkFilterByTypes">
            <label class="custom-control-label" for="checkFilterByTypes">
              <h5>Types</h5>
            </label>
          </div>
          <?php
            if ($types = $conn->query(
              "SELECT type_id, type_name FROM type"
            )) {
              while ($type = $types->fetch_assoc()) {
                $typeId = $type['type_id'];
                $typeName = $type['type_name'];
                ?>
          <div class="custom-control custom-checkbox">
            <input type="radio" name="radioTypes" class="custom-control-input checkType" id="type<?php echo $typeId; ?>" data-id="<?php echo $typeId; ?>">
            <label class="custom-control-label" for="type<?php echo $typeId; ?>"><?php echo $typeName; ?></label>
          </div>
          <?php
              }
              $types->close();
            }
          ?>
        </div>
        <div class="pb-2">
          <div class="pb-2 pt-2 custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="checkFilterByCategories">
            <label class="custom-control-label" for="checkFilterByCategories">
              <h5>Categories</h5>
            </label>
          </div>
          <button type="button" class="btn btn-secondary m-0 mb-1 p-1 pl-2 pr-2" id="clearCategories">Clear categories</button>
          <?php
            if ($categories = $conn->query(
              "SELECT category_id, category_name FROM category"
            )) {
              while ($category = $categories->fetch_assoc()) {
                $categoryId = $category['category_id'];
                $categoryName = $category['category_name'];
                ?>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input checkCategory" id="category<?php echo $categoryId; ?>" data-id="<?php echo $categoryId; ?>">
            <label class="custom-control-label" for="category<?php echo $categoryId; ?>"><?php echo $categoryName; ?></label>
          </div>
          <?php
              }
              $categories->close();
            }
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary col-2 ml-2 btnSaveFilters" data-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $(".checkType").prop('disabled', true);
    $("#clearCategories").prop('disabled', true);
    $(".checkCategory").prop('disabled', true);

    $("#checkFilterByTypes").on('change', function(e) {
      $(".checkType").prop('disabled', !this.checked);
    });
    $("#checkFilterByCategories").on('change', function(e) {
      $("#clearCategories").prop('disabled', !this.checked);
      $(".checkCategory").prop('disabled', !this.checked);
    });
    $("#clearCategories").on('click', function(e) {
      $(".checkCategory").prop('checked', false);
    });

    $(".btnSaveFilters").on('click', function(e) {
      var filterByTypes = $("#checkFilterByTypes").is(":checked");
      var filterByCategories = $("#checkFilterByCategories").is(":checked");
      if (filterByTypes || filterByCategories) {
        $("#filterState").text("(active)");
        $("#filterState").css('color', 'green');
      } else {
        $("#filterState").text("(no filters)");
        $("#filterState").css('color', 'black');
      }
      $(".provider").show();
      if (!filterByTypes && !filterByCategories) {
        return;
      }
      $(".provider").each(function(i, provider) {
        if (filterByTypes) {
          for (type of $(".checkType:checked").toArray()) {
            if (!$(provider).find(".providerType[data-id=" + $(type).data("id") + "]").length) {
              $(provider).hide();
              return;
            }
          }
        }
        if (filterByCategories) {
          for (category of $(".checkCategory:checked").toArray()) {
            if (!$(provider).find(".providerCategory[data-id=" + $(category).data("id") + "]").length) {
              $(provider).hide();
              return;
            }
          }
        }
      });
    });

    $("#searchFavourites").on('keyup', function(e) {
      var inputed = $(this).val().toLowerCase();
      var items = $(".favouriteProvider");
      // show all listed product if the searchbar is blank
      if (inputed === "") {
        items.show();
        return;
      }
      $.each(items, function() {
        var providerName = $(this).find(".card-title").text().toLowerCase();
        // true if the text inputed in the searchbar is not contained in the product's name
        if (providerName.indexOf(inputed) === -1) {
          $(this).hide();
        } else {
          $(this).show();
        }
      });
    });
    $("#searchListed").on('keyup', function(e) {
      var inputed = $(this).val().toLowerCase();
      var items = $(".listedProvider");
      // show all listed product if the searchbar is blank
      if (inputed === "") {
        items.show();
        return;
      }
      $.each(items, function() {
        var providerName = $(this).find(".card-title").text().toLowerCase();
        // true if the text inputed in the searchbar is not contained in the product's name
        if (providerName.indexOf(inputed) === -1) {
          $(this).hide();
        } else {
          $(this).show();
        }
      });
    });


    $(".btn-place-order").click(function() {
      window.location.href = "place_order.php?provider=" + $(this).parent().parent().parent().parent().data("provider-id");
    });
    /* Set navbar voice active with respective screen reader functionality */
    var homeLink = $("nav div ul li a:contains('Home')");
    homeLink.append("<span class='sr-only'>(current)</span>");
    homeLink.parent().addClass("active");

    $("button[name='addFavourite']").on('click', addFavourite);
    $("button[name='removeFavourite']").on('click', removeFavourite);
  });

  function addFavourite() {
    var provider = $(this).parent().parent().parent().parent();
    var thisButton = $(this);
    $.post("ajax/add_favourite_provider.php", {
      providerId: provider.data("provider-id")
    }).done(function(response) {
      if (response === "SUCCESS") {
        provider.fadeOut(250, function() {
          var newButton = $('<button class="btn btn-primary inline border-left" name="removeFavourite"><i class="far fa-star"></i></button>')
          newButton.on('click', removeFavourite);
          thisButton.replaceWith(newButton);
          provider.detach().appendTo("#favouriteProviders");
          provider.show();
        });
      }
    });
  }

  function removeFavourite() {
    var provider = $(this).parent().parent().parent().parent();
    var thisButton = $(this);
    $.post("ajax/remove_favourite_provider.php", {
      providerId: provider.data("provider-id")
    }).done(function(response) {
      if (response === "SUCCESS") {
        provider.fadeOut(250, function() {
          var newButton = $('<button class="btn btn-primary inline border-left" name="addFavourite"><i class="fas fa-star"></i></button>');
          newButton.on('click', addFavourite);
          thisButton.replaceWith(newButton);
          provider.detach().appendTo("#listedProviders");
          provider.show();
        });
      }
    });
  }
</script>
<?php include("fragments/connection-end.php"); ?>

</html>
