<?php

namespace com\ionxlab\ionxapi\util;

/**
 * Class ArrayList
 *
 * Wrap an array of objects of given type into a class
 */
class ArrayList {

    /**
     * Type of objects in array <br>
     * "boolean" <br>
     * "integer" <br>
     * "double" (equal float) <br>
     * "string" <br>
     * "array" <br>
     * "resource" <br>
     * and any class name if it has been included before execution <br>
     */
    private $objectsType;
    private $objects;

    /**
     * @param string $objectsType Type of objects in array <br>
     * "boolean" <br>
     * "integer" <br>
     * "double" (equal float) <br>
     * "string" <br>
     * "array" <br>
     * "resource" <br>
     * and any class name if it has been included before execution <br>
     * @throws Exception if there is a problem with objects type
     */
    public function __construct($objectsType) {
        if($objectsType==("boolean"
                || "integer"
                || "double"
                || "string"
                || "array"
                || "resources")) {
            $this->objectsType = $objectsType;
        } elseif(class_exists($objectsType)) {
            $this->objectsType = $objectsType;
        } else {
            throw new Exception(
                "Given var type is not defined. Misspelled or forgotten include ?");
        }
        $this->objects = array();
    }

    /**
     * Add an item to the array<br>
     *
     * @param Object $object has to be of the same type the one given at construction
     * @param string $name=null If name is given, it adds the variable as a keymap in the array
     */
    public function addObject($object, $name=null) {
        $objectType = gettype($object);
        if($objectType=="object") {
            $objectType = get_class($object);
        }
        if($objectType == $this->objectsType) {
            if($name == null) {
                $this->objects[] = $object;
            } else {
                $this->objects[$name] = $object;
            }

        }
    }

    /**
     * Delete an item from the array
     * @param string $name or id of the object to delete from the array
     */
    public function delObject($name) {
        if(isset($this->objects[$name])) {
            unset($this->objects[$name]);
        }
    }

    /**
     * Get an object from the array and given name or id
     * @param string $name or id of the object in array
     * @return mixed
     */
    public function getObject($name)
    {
        $result = null;
        foreach($this->objects as $object) {
            if(strtolower($object->getName())==strtolower($name)) {
                $result = $object;
                break;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * @param array $objects
     * @param bool $checkName False by default, if set to true,
     *                        check if each object in array has an accessible
     *                        name property and uses it as index key
     */
    public function setObjects($objects, $checkName=false)
    {
        //echo "setobject<br>";
        if(($objects==(null || "")) || (is_array($objects) && count($objects)==0)) {
            $this->objects = array();
            //echo "given data is null<br>";
        }

        if(is_array($objects) && count($objects)>0) {
            //echo "given data is a good array<br>";
            foreach($objects as $object) {
                $getName = false;
                $reflectionClass = new ReflectionClass($object);
                if($reflectionClass->hasMethod("getName")) {
                    //echo "object in array has getname<br>";
                    $reflectionMethod = new ReflectionMethod($object, "getName");
                    if($reflectionMethod->isPublic()) {
                        $getName = true;
                        //echo "object in array has getname public<br>";
                    }
                }
                if($checkName) {
                    //echo "check name is enabled<br>";
                    if($getName) {
                        $this->addObject($object, $object->getName());
                    } else {
                        $this->addObject($object);
                    }
                } else {
                    //echo "check is enabled but no getname<br>";
                    $this->addObject($object);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getObjectsType()
    {
        return $this->objectsType;
    }
}


?>