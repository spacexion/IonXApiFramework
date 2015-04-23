<?php

/**
 * Global Configuration
 */
class Config {

    private static $constructed = false;

    public static $sqlUser;
    public static $sqlPass;
    public static $sqlHost;
    public static $sqlPort;
    public static $sqlDbName;

    public static $logLevel;
    public static $sendDebugMessageToClient;

    /**
     * @param string $sqlUser The username of the sql connection
     * @param string $sqlPass The password of the sql connection
     * @param string $sqlHost The host of the sql connection
     * @param int $sqlPort The port of the sql connection
     * @param string $sqlDbName The Database name of the sql connection
     * @param int $logLevel The log level (0:verbose,1:debug,2:info,3:warning,4:error,5:no log)
     * @param bool $sendDebugMessageToClient If the server send back debug message in response body
     */
    public static function _construct(
            $sqlUser,
            $sqlPass,
            $sqlHost,
            $sqlPort,
            $sqlDbName,
            $logLevel = 5,
            $sendDebugMessageToClient = false) {

        self::$sqlUser = $sqlUser;
        self::$sqlPass = $sqlPass;
        self::$sqlHost = $sqlHost;
        self::$sqlPort = $sqlPort;
        self::$sqlDbName = $sqlDbName;

        self::$logLevel = $logLevel;
        self::$sendDebugMessageToClient = $sendDebugMessageToClient;
    }

    /**
     * Initialize the Config with default values (called automatically)
     */
    public static function _init() {

    	self::$logLevel = 5;
    	self::$sendDebugMessageToClient = false;
    	
    	self::$sqlUser = "root";
    	self::$sqlPass = "";
    	self::$sqlHost = "127.0.0.1";
    	self::$sqlPort = 3306;
    	self::$sqlDbName = "ionxapiframework";
    }

    /**
     * @return bool
     */
    public static function isConstructed(){
        return self::$constructed;
    }
}
Config::_init();

?>
