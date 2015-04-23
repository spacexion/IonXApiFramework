<?php
require_once realpath(__DIR__."/ApiCommand.php");

/**
 * Class ApiObject
 *
 * Allows to define the routes for an api object
 * It's basically a wrapper for an array of ApiCommand
 */
class ApiObject {

    private $name = "";
    private $manager = "";
    private $enableQuickMethod = false;
    private $commands;

    /**
     * @param string $name the object name
     * @param array $commands An array of ApiCommand
     * @param bool $enableQuickMethod false by default, if activated allow to use default manager
     *                  methods getObject, getObjects, postObject, postObjects, putObject,
     *                  deleteObject by mapping them to "[get|post|put|delete][EntityName]".
     *                  Note that you don't even need to create a Manager for your entity,
     *                  unless you want to override or add methods.
     * @param string $manager A BaseMgr based class name, null by default. Use only
     *                  if you don't want to use the "[EntityName]Manager.php" filename structure.
     */
    public function __construct($name, $commands=null, $enableQuickMethod=false, $manager = "") {
        $this->commands = new ArrayList("ApiCommand");
        $this->name = $name;
        $this->enableQuickMethod = $enableQuickMethod;
        $this->manager = $manager;

        if($commands!=null && is_array($commands)) {
            $this->setCommands($commands);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return boolean
     */
    public function isEnableQuickMethod()
    {
        return $this->enableQuickMethod;
    }

    /**
     * @param $commands
     */
    public function setCommands($commands)
    {
        $this->commands->setObjects($commands);
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        return $this->commands->getObjects();
    }
} 