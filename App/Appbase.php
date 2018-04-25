<?php
namespace App;

use App\Curl;

class Appbase {

  public $credentials;
  public $app_name;
  public static $host = "https://scalr.api.appbase.io";
  private $curl;

  public function __construct ($app_name, $credentials) {
    $this->app_name = $app_name;
    $this->credentials = $credentials;
    $this->curl = new Curl;
    $this->curl->addHeader("Authorization", "Basic " . base64_encode($this->credentials));
  }

  public function addProduct ($product) {
    $url = $this->buildUrl("products/" . $product->sku);
    $res = $this->curl->put($url, $product);
    if (!!$res->_shards->failed) {
      echo "Action failed for product {$product->sku}.";
    } else {
      if ($res->_version === 1) {
        echo "Product {$product->sku} created."."\n";
      } else {
        echo "Product {$product->sku} updated."."\n";
      }
    }
    return $res;
  }

  public function addProducts ($products) {
    $data = $products;
    $result = [];
    while (count($data) > 1) {
      $bulk = array_splice($data, 0, 1000);
      $response = $this->bulk($bulk);
      $count = count($bulk);
      $res = $count / 2 ." products from " . $bulk[1]->sku ." to ". ($bulk[$count - 1]->sku);
      if (isset($response->error)) {
        $res .= " not synced. Reason ". $response->error->reason;
      } else {
        $res .= " synced.";
      }
      // Pushing response to $result array
      echo $res."\n";
      array_push($result, $res);
    }
    return $result;
  }

  public function getLastSyncTimestamp() {
    $url = $this->buildUrl("/meta/sync_time/_source");
    $res = $this->curl->get($url);
    if ($res) {
      return $res->date;
    } else {
      return false;
    }
  }
  public function setSyncTimestamp($timestamp) {
    $url = $this->buildUrl("/meta/sync_time");
    $res = $this->curl->put( $url, [ "date"  => $timestamp ] );
    return $res;
  }

  public function bulk ($data) {
    $url = $this->buildUrl("_bulk");
    $bulk = '';

    foreach ($data as $value) {
      $bulk .= \json_encode($value);
      $bulk .= "\n";
    }

    $this->curl->setContentType("application/x-ndjson");
    $res = $this->curl->post( $url, $bulk );
    return $res;
  }

  public function buildUrl ( $endpoint) {
    return static::$host . "/" . $this->app_name . "/" . $endpoint;
  }
}
