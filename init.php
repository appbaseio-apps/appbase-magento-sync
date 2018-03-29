<?php
require_once(__DIR__ . "/vendor/autoload.php");

use Dotenv\Dotenv;
use App\Megento;
use App\Appbase;

/**
* ENV configuration and loading variables
 */
(new Dotenv(__DIR__))->load();

// Megento Configuration
$megento_username = env('MEGENTO_USERNAME');
$megento_password = env('MEGENTO_PASSWORD');
$megento = (new Megento(["username" => $megento_username , "password" => $megento_password], "http://13.71.18.199"));

// Appbase configuration
$appbase_secret = env('APPBASE_SECRET');
$appbase_app_name = env('APPBASE_APP_NAME');
$appbase = (new Appbase($appbase_app_name, $appbase_secret));
