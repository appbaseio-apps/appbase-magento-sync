<?php
use Curl\Curl;

function env ( $name, $default = "" ) {
  return empty( $_ENV[$name] )  ? $default : $_ENV[$name];
}

function curl() {
  return new Curl();
}
