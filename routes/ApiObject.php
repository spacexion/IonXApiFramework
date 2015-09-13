<?php

namespace IonXLab\IonXApi\routes;
use IonXLab\IonXApi\util\ArrayCollection;

/**
 * Class ApiObject
 *
 * Allows to define the routes for an api object
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
     *                  if you don't want to use the "[EntityName]Mgr" filename structure.
     */
    public function __construct($name, $commands=null, $enableQuickMethod=false, $manager=null) {
        $this->commands = new ArrayCollection("IonXApi\\routes\\ApiCommand");
        $this->name = $name;
        $this->enableQuickMethod = $enableQuickMethod;

        if(is_null($manager)) {
            $this->manager = ucfirst(strtolower($name))."Mgr";
        } else {
            $this->manager = $manager;
        }

        $this->setCommands($commands);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getManager() {
        return $this->manager;
    }

    /**
     * @return boolean
     */
    public function isQuickMethodEnabled() {
        return $this->enableQuickMethod;
    }

    /**
     * @param $name
     * @return string
     */
    public function getCommand($name) {
        return $this->commands->get($name);
    }

    /**
     * @return ArrayCollection
     */
    public function getCommands() {
        return $this->commands;
    }

    /**
     * @param ApiCommand[] $commands
     */
    public function setCommands($commands) {

        if(!is_null($commands) && is_array($commands)) {
            foreach($commands as $command) {
                $this->commands->addAt($command->getName(), $command);
            }
        }
    }
} 