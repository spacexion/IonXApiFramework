<?php

namespace IonXApi\builtin\base;

/**
 * The Base Class for API Models
 * @author Nicolas Gezequel
 */
class BaseModel {

    /**
     * Return associative array of current object vars
     * @return array
     */
    public function toArray($array) {
        unset($array["__initializer__"]);
        unset($array["__cloner__"]);
        unset($array["__isInitialized__"]);
        foreach ($array as $var => $value) {
            // if it's not null
            if ($array[$var] != null) {
                // if it's an entity/model
                if (is_object($array[$var])) {
                    $method = "get" . ucfirst($var);
                    $array[$var] = $this->$method()->toArray();
                    // if it's an array of entity/model
                } elseif (is_array($array[$var])) {
                    // if array is not empty
                    if (count($array[$var]) > 0) {
                        // if first object is an entity/model
                        if (is_object($array[$var][0])) {
                            $tmparray = array();
                            foreach ($array[$var] as $object) {
                                $tmparray[] = $object->toArray();
                            }
                            $array[$var] = $tmparray;
                        }
                    }
                }
            }
        }
        return $array;
    }

    /**
     * Set the current model variables with given $array
     * @param array the associative array with class parameters
     */
    public function setFromArray($array) {
        foreach ($array as $var => $value) {
            if (array_key_exists($var, $array)) {
                $method = "set" . ucfirst($var);
                $this->$method($value);
            }
        }
    }

    /**
     * Default Method
     * Return an array with rw permission on each property of the model
     * Default:(read for everyone write for admin)
     * @return array
     */
    public function getPermissions($vars, $default = array(0, 0)) {
        $permissions = array();
        foreach ($vars as $var => $value) {
            $permissions[$var] = $default;
        }
        return $permissions;
    }

}

?>