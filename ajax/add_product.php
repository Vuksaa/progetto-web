<?php
session_start();
include("../fragments/connection-begin.php");
if ($statement=$conn->prepare(
  "CALL product_add(?, '', ?, ?, @insertedProductId)"
  )) {
    if($statement->bind_param('sdi', $_POST['name'], $_POST['price'], $_SESSION['user_id'])) {
      if($statement->execute()) {
        $productId = $statement->get_result()->fetch_assoc()['insertedProductId'];
        $statement->close();
        if ($statement = $conn->prepare(
          "CALL product_ingredient_add(?, ?)"
        )) {
          if ($statement->bind_param("ii", $productId, $ingredientId)) {
            foreach ($_POST['ingredients'] as $ingredientId) {
              if (!$statement->execute()) {
                echo "ERROR: Execution failed: ".$statement->error;
                $statement->close();
                include("../fragments/connection-end.php");
              }
            }
            echo "SUCCESS";
          } else {
            echo "ERROR: Bind failed.";
          }
        } else {
          echo "ERROR: Prepare statement failed.";
        }
      } else {
        echo "ERROR: Execution failed: ".$statement->error;
      }
    } else {
      echo "ERROR: Bind failed.";
    }
} else {
  echo "ERROR: Prepare statement failed.";
}
$statement->close();
include("../fragments/connection-end.php");
?>
