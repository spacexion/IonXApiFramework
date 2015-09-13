<?php

namespace IonXApi\util;

require_once __DIR__."/AutoLoad.php";

use IonXApi\Config;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityMgr {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
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

        $config = Setup::createAnnotationMetadataConfiguration(
            array(Config::$folderNameModels),
            $isDevMode);

        $config->setProxyDir(realpath(__DIR__."/../vendor/doctrine/proxy/"));
        $config->setProxyNamespace('IonXApi\Proxies');

        self::$entityManager = EntityManager::create($dbParams, $config);
    }

}

EntityMgr::_init();
?>