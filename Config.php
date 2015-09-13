<?php

namespace IonXApi;

use IonXApi\util\Util;

require_once __DIR__."/util/Util.php";

/**
 * Global Configuration
 */
class Config {

    /**
     * @var bool If is Config::__construct() has been called
     */
    private static $constructed = false;

    /**
     * @var string the namespace of the user application
     */
    public static $appNamespace;
    /**
     * @var string The username of the SQL Server Connection
     */
    public static $sqlUser;
    /**
     * @var string The password of the SQL Server Connection
     */
    public static $sqlPass;
    /**
     * @var string The host of the SQL Server Connection
     */
    public static $sqlHost;
    /**
     * @var string The port of the SQL Server Connection
     */
    public static $sqlPort;
    /**
     * @var string The DatabaseName of the SQL Server Connection
     */
    public static $sqlDbName;

    /**
     * @var string Base uri of the api ("api/")
     */
    public static $uriApi;
    /**
     * @var string Physical absolute path where IonXApiFramework is stored ("/var/www/resources/IonXApiFramework/")
     */
    public static $pathIonXApiFramework;
    /**
     * @var string Physical absolute path where projects folder are stored ("/var/www/api/projects/")
     */
    public static $pathProjects;

    /**
     * @var string The folder name where controllers are stored (must be the same in all projects)
     */
    public static $folderNameControllers;
    /**
     * @var string The folder name where models are stored (must be the same in all projects)
     */
    public static $folderNameModels;
    /**
     * @var string The folder name where managers are stored (must be the same in all projects)
     */
    public static $folderNameManagers;

    /**
     * Construct the config file with all parameters
     * @param string $appNamespace The user app Namespace
     * @param string $sqlUser The username of the sql connection
     * @param string $sqlPass The password of the sql connection
     * @param string $sqlHost The host of the sql connection
     * @param int $sqlPort The port of the sql connection
     * @param string $sqlDbName The Database name of the sql connection
     * @param string $uriApi Uri to call api (has to be in the .htaccess at DocumentRoot)
     * @param string $pathIonXApiFramework Absolute Path of the folder where IonXApiFramework is stored
     * @param string $pathProjects Absolute Path of the folder where Projects are stored
     * @param string $folderNameControllers The folder name where controllers are stored (must be the same in all projects)
     * @param string $folderNameModels The folder name where models are stored (must be the same in all projects)
     * @param string $folderNameManagers The folder name where managers are stored (must be the same in all projects)
     */
    public static function _construct(
            $appNamespace,
            $sqlUser,
            $sqlPass,
            $sqlHost,
            $sqlPort,
            $sqlDbName,
            $uriApi = "",
            $pathIonXApiFramework = "",
            $pathProjects = "",
            $folderNameControllers = "",
            $folderNameModels = "",
            $folderNameManagers = "") {

        if(Util::isGoodString($appNamespace)) {
            self::$appNamespace = $appNamespace;
        }
        if(Util::isGoodString($sqlUser)) {
            self::$sqlUser = $sqlUser;
        }
        if(Util::isGoodString($sqlPass)) {
            self::$sqlPass = $sqlPass;
        }
        if(Util::isGoodString($sqlHost)) {
            self::$sqlHost = $sqlHost;
        }
        if(Util::isGoodString($sqlPort)) {
            self::$sqlPort = $sqlPort;
        }
        if(Util::isGoodString($sqlDbName)) {
            self::$sqlDbName = $sqlDbName;
        }
        if(Util::isGoodString($uriApi)) {
            self::$uriApi = $uriApi;
        }
        if(Util::isGoodString($pathIonXApiFramework)) {
            self::$pathIonXApiFramework = $pathIonXApiFramework;
        }
        if(Util::isGoodString($pathProjects)) {
            self::$pathProjects = $pathProjects;
        }

        if(Util::isGoodString($folderNameControllers)) {
            self::$folderNameControllers = $folderNameControllers;
        }
        if(Util::isGoodString($folderNameModels)) {
            self::$folderNameModels = $folderNameModels;
        }
        if(Util::isGoodString($folderNameManagers)) {
            self::$folderNameManagers = $folderNameManagers;
        }
    }

    /**
     * Initialize the Config with default values (called automatically)
     */
    public static function _init() {

        self::$appNamespace = "IonXApiApp";
        self::$sqlUser = "root";
    	self::$sqlPass = "";
    	self::$sqlHost = "127.0.0.1";
    	self::$sqlPort = 3306;
    	self::$sqlDbName = "ionxapiframework";

        self::$uriApi = "api/";
        self::$pathIonXApiFramework = "/var/www/IonXApiFramework/";
        self::$pathProjects = "/var/www/api/projects/";

        self::$folderNameControllers = "controllers";
        self::$folderNameModels = "models";
        self::$folderNameManagers = "managers";
    }

    /**
     * @return bool
     */
    public static function isConstructed(){
        return self::$constructed;
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
}
Config::_init();

?>
