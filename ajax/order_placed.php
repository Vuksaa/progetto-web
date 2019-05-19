<?php
session_start();
$order = json_decode($_POST["data"], true);
// TODO: server-side validation?
include("../fragments/connection-begin.php");

// check if the address has been selected from already existing addresses or if
// it has been entered. for the latter, also check if the address should be saved
if (isset($order["enteredAddress"])) {
  $order_address = $order["enteredAddress"];
  if ($order["saveAddress"]) {
    if ($statement=$conn->prepare("
      INSERT INTO `uni_web_prod`.`address` (`address_name`, `address_info`, `client_id`)
      VALUES (?, ?, ?);
    ")) {
      $statement->bind_param('ssi', $order["enteredAddressName"], $order_address, $_SESSION["user_id"]));
      $statement->execute();
    } else {
      echo "ORDER_FAIL_PREPARE_ADDRESS_INSERT";
    }
  }
} else {
  $order_address = $order["selectedAddress"];
}
$statement->close();

// create the order record
if ($statement=$conn->prepare("
  INSERT INTO `order` (order_address)
  VALUES (?);
")) {
  $statement->bind_param('s', $order_address);
  $statement->execute();
  $order_id = $conn->insert_id;
  $statement->close();

  // create the ordered products' records
  if ($statement=$conn->prepare("
    INSERT INTO product_order (product_id, order_id, notes, quantity)
    VALUES (?, ?, ?, ?);
  ")) {
    $statement->bind_param('iisi', $orderedProduct_id, $order_id, $orderedProduct_notes, $orderedProduct_quantity);
    foreach ($order["products"] as $product) {
      $orderedProduct_id = $product["id"];
      $orderedProduct_notes = $product["notes"];
      $orderedProduct_quantity = $product["quantity"];
      $statement->execute();
    }
    echo "ORDER_SUCCESS";
  } else {
    echo "ORDER_FAIL_PREPARE_PRODUCT_INSERT";
  }
} else {
  echo "ORDER_FAIL_PREPARE_ORDER_INSERT";
}
$statement->close();
include("../fragments/connection-end.php");
?>
