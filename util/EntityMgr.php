<?php

namespace IonXLab\IonXApi\util;

use IonXLab\IonXApi\Config;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class EntityMgr {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public static $entityManager;

    public function __construct() {
        self::_init();
    }

    public static function _init() {

        $config = Config::getInstance();

        // the connection configuration
        $dbParams = array(
            'driver' => 'pdo_mysql',
            'user' => $config->getSqlUser(),
            'password' => $config->getSqlPass(),
            'dbname' => $config->getSqlDbName(),
            'host' => $config->getSqlHost(),
            'port' => $config->getSqlPort(),
        );

        $paths = array();
        $projects = $config->getApiRoutes()->getProjects()->toArray();
        foreach($projects as $project) {
            $path = Util::file_exists_ci(
                Util::buildPath($config->getPathProjects(), $project->getName(), $config->getFolderNameModels()));
            if(is_string($path)) {
                $paths[] = $path;
            }
        }

        $config = Setup::createAnnotationMetadataConfiguration(
            $paths,
            $config->isDevMode());

        $config->setProxyDir(realpath(__DIR__."/../../../doctrine/proxy/"));
        $config->setProxyNamespace('IonXApi\Proxies');

        self::$entityManager = EntityManager::create($dbParams, $config);
    }

}

EntityMgr::_init();
?>