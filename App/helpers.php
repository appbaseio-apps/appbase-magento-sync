<?php
use Curl\Curl;

function env ( $name, $default = "" ) {
  return empty( $_ENV[$name] )  ? $default : $_ENV[$name];
}

function curl() {
  return new Curl();
}

function productsMaxUpdatedAt(Array $array) {
  $max = max(array_map(function ($arr) {
    return strtotime($arr->updated_at);
  }, $array));
  return date('Y-m-d H:i:s', $max); // 2012-06-11 08:30:49
}
