<?php
try {
  require(__DIR__. '/init.php');

  $date = $appbase->getLastSyncTimestamp();

  $products = ($megento->getProductsAfter($date)->items);

  if (count($products) === 0) {
    throw new Exception("No products found.");
  }

  foreach ($products as $product) {
    $appbase->addProduct($bulk);
  }

} catch (Exception $e) {
  echo $e->getMessage();
}
