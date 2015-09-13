<?php

/**
 * Add IonXApi entry into the composer autoloader
 * @var \Composer\Autoload\ClassLoader
 */
$loader = require __DIR__ . '/../vendor/autoload.php';

$loader->addPsr4('IonXApi\\', __DIR__."/../");

return $loader;
