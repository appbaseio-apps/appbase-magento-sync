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
$magento_username = env('magento_USERNAME');
$magento_password = env('magento_PASSWORD');
$magento = (new Magento(["username" => $magento_username , "password" => $magento_password], "http://13.71.18.199"));

// Appbase configuration
$appbase_secret = env('APPBASE_SECRET');
$appbase_app_name = env('APPBASE_APP_NAME');
$appbase = (new Appbase($appbase_app_name, $appbase_secret));
