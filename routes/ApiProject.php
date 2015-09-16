<?php

namespace IonXLab\IonXApi\routes;
use IonXLab\IonXApi\util\ArrayCollection;

/**
 * Class ApiProject
 *
 * Allow to quickly define each project routes
 */
class ApiProject {

    /**
     * @var ArrayCollection
     */
    private $objects;
    /**
     * @var string
     */
    private $name;

    public function __construct($name, $objects=null) {
        $this->objects = new ArrayCollection("IonXLab\\IonXApi\\routes\\ApiObject");
        $this->name = $name;

        $this->setObjects($objects);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param ApiObject $object
     */
    public function addObject($object) {
        $this->objects->add($object->getName(), $object);
    }

    /**
     * @param string $name
     */
    public function delObject($name) {
        $this->objects->remove($name);
    }

    /**
     * @param string $name
     * @return ApiObject
     */
    public function getObject($name) {
        return $this->objects->get($name);
    }

    /**
     * @return ArrayCollection
     */
    public function getObjects() {
        return $this->objects;
    }

    /**
     * @param ApiObject[] $objects
     */
    public function setObjects($objects) {
        if(!is_null($objects) && is_array($objects)) {
            foreach($objects as $object) {
                $this->objects->addAt($object->getName(), $object);
            }
        }
    }
}


?>