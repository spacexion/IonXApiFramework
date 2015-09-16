<?php
$autoloader = require_once __DIR__."/../vendor/autoload.php";
$config = require_once __DIR__ . "/config.php";

use IonXLab\IonXApi\IonXApi;

$autoloader->addPsr4("MyTestApp\\", __DIR__);

$api = new IonXApi();
$api->process();
