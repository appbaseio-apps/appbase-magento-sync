<?php
namespace App;

class Curl {

  private $headers = [];
  private $data = [];
  public $contentType = [ 'Content-Type: application/json' ];

  public function addHeaders($headers) {
    foreach ($headers as $header) {
      $this->setHeader($header);
    }
  }

  public function addHeader($header, $value) {
    array_push($this->headers, $header .": ". $value);
  }

  public function get($url, $data = []) {
    return $this->exec_get($url, $data);
  }

  public function delete($url, $data = []) {
    return $this->exec_get($url, $data, 'DELETE');
  }

  public function post($url, $data = []) {
    return $this->exec($url, $data);
  }

  public function put($url, $data = []) {
    return $this->exec($url, $data, 'PUT');
  }

  public function patch($url, $data = []) {
    return $this->exec($url, $data, 'PATCH');
  }

  public function setContentType($value) {
    $this->contentType = ["Content-Type: ". $value];
  }

  public function exec($url, $data = [], $type = 'POST') {
    $ch = curl_init($url);
    $data_string = is_string($data) ? $data : json_encode($data);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers + $this->contentType);
    $response = curl_exec($ch);
    if (!$response) {
      echo curl_error($ch);
      exit(1);
    }
    $response = json_decode($response);
    return $response;
  }

  public function exec_get($url, $data = [], $type = 'GET') {
    $url = count($data) > 0 ? $url . "?" . \http_build_query($data) : $url;
    $ch = curl_init($url);
    $data_string = json_encode($data);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
    $response = curl_exec($ch);
    if (!$response) {
      echo curl_error($ch);
      exit(1);
    }
    $response = json_decode($response);
    return $response;
  }
}
