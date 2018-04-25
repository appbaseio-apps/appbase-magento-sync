<?php
try {
  require(__DIR__. '/init.php');

  $products = ($magento->getAllProducts()->items);

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

  echo "You can view the synced data at https://dashboard.appbase.io/browser/{$appbase_app_name}\n";

} catch (Exception $e) {
  echo $e->getMessage();
}
