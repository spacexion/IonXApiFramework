<?php

namespace com\ionxlab\ionxapi\routes;

/**
 * Class ApiProject
 *
 * Allow to quickly define each project routes
 * It's basically an ArrayList of ApiObject
 */
class ApiProject{

    private $name = "";
    private $objects;

    public function __construct($name, $objects=null) {
        $this->name = $name;
        $this->objects = new ArrayList("ApiObject");
        if($objects!=null && is_array($objects)) {
            $this->setObjects($objects);
        }
    }

    public function getName() {
        return $this->name;
    }

    /**
     * @param ApiObject $object
     */
    public function addObject($object) {
        $this->objects->addObject($object, $object->getName());
    }

    /**
     * @param string $name
     */
    public function delObject($name) {
        $this->objects->delObject($name);
    }

    /**
     * @param string $name
     * @return ApiObject
     */
    public function getObject($name)
    {
        return $this->objects->getObject($name);
    }

    /**
     * @return ArrayList
     */
    public function getObjects()
    {
        return $this->objects->getObjects();
    }

    /**
     * @param array $objects
     */
    public function setObjects($objects)
    {
        $this->objects->setObjects($objects, true);
    }
}


?>