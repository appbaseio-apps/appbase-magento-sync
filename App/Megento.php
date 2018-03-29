<?php
namespace App;

use App\Curl;

class Megento {

  const GET_PRODUCTS = "products";
  const ADMIN_TOKEN = "integration/admin/token";
  private $credentials;
  private $curl;
  public $host;
  public $type = "rest";
  public $version = "default/V1";
  public $token;

  public function __construct ($credentials, $host) {
    if ( !is_array($credentials) || empty($credentials['username']) || empty($credentials['password']) ) {
      throw new \Exception("Invalid megento credentials");
    }

    $this->credentials = $credentials;
    $this->host = $host;
    $this->curl = new Curl();
    $this->token = $this->getCredentials(true);
    $this->curl->addHeader("Authorization", "Bearer " . $this->token);
  }

  public function getAllProducts () {
    $search = [
      'filterGroups' => [
        0 => [
          'filters' => [
             0 => [
               'field' => 'created_at',
               'value' => '1900-01-01 00:00:00',
               'condition_type' => 'gt'
             ]
          ]
        ]
      ]
    ];
    return $this->getProducts($search);
  }

  public function getProductsAfter ($date) {
    $search = [
      'filterGroups' => [
        0 => [
          'filters' => [
             0 => [
               'field' => 'updated_at',
               'value' => $date,
               'condition_type' => 'gt'
             ]
          ]
        ]
      ]
    ];
    return $this->getProducts($search);
  }

  public function getProducts ($search) {
    return $this->curl->get($this->buildUrl(self::GET_PRODUCTS), ["searchCriteria" => $search]);
  }

  public function buildUrl($endpoint) {
    return $this->host . '/' . $this->type . "/" . $this->version . "/" . $endpoint;
  }

  public function getCredentials($force = false) {
    if ( !empty($this->token) && !$force ) {
      return $this->token;
    }
    $adminUrl = $this->buildUrl(self::ADMIN_TOKEN);
    return $this->curl->post($adminUrl, $this->credentials);
  }
}
