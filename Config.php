<?php

namespace IonXLab\IonXApi;

use IonXLab\IonXApi\routes\ApiRoutes;
use IonXLab\IonXApi\util\Util;

require_once __DIR__."/util/Util.php";

/**
 * Global Configuration
 */
class Config {

    /**
     * @var string the namespace of the user application
     */
    private $appNamespace;
    /**
     * @var string The username of the SQL Server Connection
     */
    private $sqlUser;
    /**
     * @var string The password of the SQL Server Connection
     */
    private $sqlPass;
    /**
     * @var string The host of the SQL Server Connection
     */
    private $sqlHost;
    /**
     * @var string The port of the SQL Server Connection
     */
    private $sqlPort;
    /**
     * @var string The DatabaseName of the SQL Server Connection
     */
    private $sqlDbName;

    /**
     * @var string Base uri of the api ("api/")
     */
    private $uriApi;
    /**
     * @var string Physical absolute path where IonXApiFramework is stored ("/var/www/resources/IonXApiFramework/")
     */
    private $pathIonXApiFramework;
    /**
     * @var string Physical absolute path where projects folder are stored ("/var/www/api/projects/")
     */
    private $pathProjects;

    /**
     * @var string The folder name where controllers are stored (must be the same in all projects)
     */
    private $folderNameControllers;
    /**
     * @var string The folder name where models are stored (must be the same in all projects)
     */
    private $folderNameModels;
    /**
     * @var string The folder name where managers are stored (must be the same in all projects)
     */
    private $folderNameManagers;

    /**
     * @var bool If the application is in development or production mode (mostly for Doctrine)
     */
    private $isDevMode = false;

    /**
     * @var ApiRoutes The defined routes
     */
    private $apiRoutes;

    /**
     * @var \IonXLab\IonXApi\Config
     */
    private static $instance = null;


    private function __construct() {
    }

    /**
     * Return current or new Config instance
     * @return Config
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new Config();
            self::$instance->init(null,null,null,null,null,null,null,null,null,null,null,null,null);
        }
        return self::$instance;
    }

    /**
     * Construct the config file with all parameters
     * @param string $appNamespace The user app Namespace
     * @param string $sqlUser The username of the sql connection
     * @param string $sqlPass The password of the sql connection
     * @param string $sqlHost The host of the sql connection
     * @param int $sqlPort The port of the sql connection
     * @param string $sqlDbName The Database name of the sql connection
     * @param ApiRoutes $apiRoutes the defined routes
     * @param string $uriApi Uri to call api (has to be in the .htaccess at DocumentRoot)
     * @param string $pathIonXApiFramework Absolute Path of the folder where IonXApiFramework is stored
     * @param string $pathProjects Absolute Path of the folder where Projects are stored
     * @param string $folderNameControllers The folder name where controllers are stored (must be the same in all projects)
     * @param string $folderNameModels The folder name where models are stored (must be the same in all projects)
     * @param string $folderNameManagers The folder name where managers are stored (must be the same in all projects)
     * @param bool $isDevMode If the application is in development or production mode (mostly for Doctrine)
     */
    public function init(
            $appNamespace,
            $sqlUser,
            $sqlPass,
            $sqlHost,
            $sqlPort,
            $sqlDbName,
            $apiRoutes,
            $uriApi = "",
            $pathIonXApiFramework = "",
            $pathProjects = "",
            $folderNameControllers = "",
            $folderNameModels = "",
            $folderNameManagers = "",
            $isDevMode=null) {

        if(Util::isGoodString($appNamespace)) {
            $this->appNamespace = $appNamespace;
        } else {
            $this->appNamespace = "IonXApiApp";
        }

        if(Util::isGoodString($sqlUser)) {
            $this->sqlUser = $sqlUser;
        } else {
            $this->sqlUser = "root";
        }

        if(Util::isGoodString($sqlPass)) {
            $this->sqlPass = $sqlPass;
        } else {
            $this->sqlPass = "";
        }

        if(Util::isGoodString($sqlHost)) {
            $this->sqlHost = $sqlHost;
        } else {
            $this->sqlHost = "127.0.0.1";
        }

        if(is_numeric($sqlPort)) {
            $this->sqlPort = $sqlPort;
        } else {
            $this->sqlPort = 3306;
        }

        if(Util::isGoodString($sqlDbName)) {
            $this->sqlDbName = $sqlDbName;
        } else {
            $this->sqlDbName = "ionxapiapp";
        }

        if(gettype($apiRoutes)=="object" && get_class($apiRoutes)=="IonXLab\\IonXApi\\routes\\ApiRoutes") {
            $this->apiRoutes = $apiRoutes;
        }

        if(Util::isGoodString($uriApi)) {
            $this->uriApi = $uriApi;
        } else {
            $this->uriApi = "api/";
        }

        if(Util::isGoodString($pathIonXApiFramework)) {
            $this->pathIonXApiFramework = $pathIonXApiFramework;
        } else {
            $this->pathIonXApiFramework = "/var/www/vendor/ionxlab/ionxapi/";
        }

        if(Util::isGoodString($pathProjects)) {
            $this->pathProjects = $pathProjects;
        } else {
            $this->pathProjects = "/var/www/api/projects/";
        }

        if(Util::isGoodString($folderNameControllers)) {
            $this->folderNameControllers = $folderNameControllers;
        } else {
            $this->folderNameControllers = "controllers";
        }

        if(Util::isGoodString($folderNameModels)) {
            $this->folderNameModels = $folderNameModels;
        } else {
            $this->folderNameModels = "models";
        }

        if(Util::isGoodString($folderNameManagers)) {
            $this->folderNameManagers = $folderNameManagers;
        } else {
            $this->folderNameManagers = "managers";
        }

        if(!is_null($isDevMode) && is_bool($isDevMode)) {
            $this->isDevMode = $isDevMode;
        } else {
            $this->isDevMode = false;
        }
    }

    /**
     * @return bool
     */
    public static function isOSLinux() {
        return is_int(strpos(strtolower(php_uname('s')), "linux", 0));
    }

    /**
     * @return bool
     */
    public static function isOSWindows() {
        return is_int(strpos(strtolower(php_uname('s')), "win", 0));
    }

    /**
     * @return string
     */
    public function getAppNamespace()
    {
        return $this->appNamespace;
    }

    /**
     * @param string $appNamespace
     */
    public function setAppNamespace($appNamespace)
    {
        $this->appNamespace = $appNamespace;
    }

    /**
     * @return string
     */
    public function getSqlUser()
    {
        return $this->sqlUser;
    }

    /**
     * @param string $sqlUser
     */
    public function setSqlUser($sqlUser)
    {
        $this->sqlUser = $sqlUser;
    }

    /**
     * @return string
     */
    public function getSqlPass()
    {
        return $this->sqlPass;
    }

    /**
     * @param string $sqlPass
     */
    public function setSqlPass($sqlPass)
    {
        $this->sqlPass = $sqlPass;
    }

    /**
     * @return string
     */
    public function getSqlHost()
    {
        return $this->sqlHost;
    }

    /**
     * @param string $sqlHost
     */
    public function setSqlHost($sqlHost)
    {
        $this->sqlHost = $sqlHost;
    }

    /**
     * @return string
     */
    public function getSqlPort()
    {
        return $this->sqlPort;
    }

    /**
     * @param string $sqlPort
     */
    public function setSqlPort($sqlPort)
    {
        $this->sqlPort = $sqlPort;
    }

    /**
     * @return string
     */
    public function getSqlDbName()
    {
        return $this->sqlDbName;
    }

    /**
     * @param string $sqlDbName
     */
    public function setSqlDbName($sqlDbName)
    {
        $this->sqlDbName = $sqlDbName;
    }

    /**
     * @return string
     */
    public function getUriApi()
    {
        return $this->uriApi;
    }

    /**
     * @param string $uriApi
     */
    public function setUriApi($uriApi)
    {
        $this->uriApi = $uriApi;
    }

    /**
     * @return string
     */
    public function getPathIonXApiFramework()
    {
        return $this->pathIonXApiFramework;
    }

    /**
     * @param string $pathIonXApiFramework
     */
    public function setPathIonXApiFramework($pathIonXApiFramework)
    {
        $this->pathIonXApiFramework = $pathIonXApiFramework;
    }

    /**
     * @return string
     */
    public function getPathProjects()
    {
        return $this->pathProjects;
    }

    /**
     * @param string $pathProjects
     */
    public function setPathProjects($pathProjects)
    {
        $this->pathProjects = $pathProjects;
    }

    /**
     * @return string
     */
    public function getFolderNameControllers()
    {
        return $this->folderNameControllers;
    }

    /**
     * @param string $folderNameControllers
     */
    public function setFolderNameControllers($folderNameControllers)
    {
        $this->folderNameControllers = $folderNameControllers;
    }

    /**
     * @return string
     */
    public function getFolderNameModels()
    {
        return $this->folderNameModels;
    }

    /**
     * @param string $folderNameModels
     */
    public function setFolderNameModels($folderNameModels)
    {
        $this->folderNameModels = $folderNameModels;
    }

    /**
     * @return string
     */
    public function getFolderNameManagers()
    {
        return $this->folderNameManagers;
    }

    /**
     * @param string $folderNameManagers
     */
    public function setFolderNameManagers($folderNameManagers)
    {
        $this->folderNameManagers = $folderNameManagers;
    }

    /**
     * @return ApiRoutes
     */
    public function getApiRoutes()
    {
        return $this->apiRoutes;
    }

    /**
     * @param ApiRoutes $apiRoutes
     */
    public function setApiRoutes($apiRoutes)
    {
        $this->apiRoutes = $apiRoutes;
    }

    /**
     * @return boolean
     */
    public function isDevMode()
    {
        return $this->isDevMode;
    }

    /**
     * @param boolean $isDevMode
     */
    public function setIsDevMode($isDevMode)
    {
        $this->isDevMode = $isDevMode;
    }
}

?>
