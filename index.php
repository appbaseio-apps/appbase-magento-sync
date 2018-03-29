<?php
try {
  require(__DIR__. '/init.php');

  $timestamp = date("Y-m-d H:i:s");
  $products = ($megento->getAllProducts()->items);

  if (count($products) === 0) {
    throw new Exception("No products found.");
  }

  $bulk = [];
  foreach ($products as $product) {
    $id = $product->sku;
    array_push($bulk, ["index" => [ "_type" => "products", "_id" => $id ]]);
    array_push($bulk, $product);
  }
$appbase->addProducts($bulk);
$appbase->setSyncTimestamp($timestamp);

} catch (Exception $e) {
  echo $e->getMessage();
}
