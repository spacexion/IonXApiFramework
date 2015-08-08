<?php

namespace com\ionxlab\ionxapi;

require_once realpath(__DIR__."/Config.php");
require_once realpath(__DIR__."/vendor/autoload.php");

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityMgr {

    public static $entityManager;

    public static function _init() {

        // Prod or Release Environment
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => Config::$sqlUser,
            'password' => Config::$sqlPass,
            'dbname' => Config::$sqlDbName,
            'host' => Config::$sqlHost,
            'port' => Config::$sqlPort,
        );

        $config = Setup::createAnnotationMetadataConfiguration(Config::$pathsModels, $isDevMode);
        $config->setProxyDir(realpath(__DIR__."/vendor/doctrine/proxy/"));
        $config->setProxyNamespace('IonxLab\Proxies');

        self::$entityManager = EntityManager::create($dbParams, $config);
    }

}

EntityMgr::_init();
?>