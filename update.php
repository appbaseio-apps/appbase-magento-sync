<?php
try {
  require(__DIR__. '/init.php');

  $date = $appbase->getLastSyncTimestamp();

  $products = ($magento->getProductsAfter($date)->items);

  if (count($products) === 0) {
    throw new Exception("No products found.");
  }

  $timestamp = (productsMaxUpdatedAt($products));
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
  exit(1);
}
