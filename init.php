<?php
require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;
use App\Magento;
use App\Appbase;

/**
* ENV configuration and loading variables
 */
(new Dotenv(__DIR__))->load();

// magento Configuration
$magento_username = env('MAGENTO_USERNAME');
$magento_password = env('MAGENTO_PASSWORD');
$magento_host = env('MAGENTO_HOST');
$magento = (new Magento(["username" => $magento_username , "password" => $magento_password], $magento_host));

// Appbase configuration
$appbase_secret = env('APPBASE_API_KEY');
$appbase_app_name = env('APPBASE_APP');
$appbase = (new Appbase($appbase_app_name, $appbase_secret));
