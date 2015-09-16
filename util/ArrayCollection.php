<?php

namespace IonXLab\IonXApi\util;

use Exception;


/**
 * Class ArrayCollection
 *
 * Wraps an array of objects of given Type into a Class
 *
 * @author Nicolas Gezequel
 * @package IonXApi\Util
 */
class ArrayCollection {

    /**
     * Type of objects in array <br>
     * "boolean" <br>
     * "integer" <br>
     * "double" (equal float) <br>
     * "string" <br>
     * "array" <br>
     * and any class name if it has been included before execution <br>
     */
    private $type;
    /**
     * @var array
     */
    private $elements;
    /**
     * @var bool
     */
    private $keepKeyCase;

    /**
     * @param string $type ("boolean"|"integer"|"double"|"string"|"array"|"MyClassName")
     * @param bool $keepKeyCase=false
     * @param mixed[] $elements=null
     * @throws Exception
     */
    public function __construct($type, $keepKeyCase=false, $elements=null) {
        $this->type = $type;
        $this->keepKeyCase = $keepKeyCase;

        if($type==("boolean"
                || "integer"
                || "double"
                || "string"
                || "array")) {
            $this->type = $type;
        } elseif(class_exists($type)) {
            $this->type = $type;
        } else {
            throw new Exception(
                "Given Type is not defined. Misspelled or forgotten include ?");
        }

        if(!$this->addAll($elements)) {
            $this->elements = array();
        }
    }

    /**
     * Appends the specified element to the end of this list.
     * @param $element
     * @return boolean
     */
    public function add($element) {
        if(gettype($element) == $this->type || get_class($element) == $this->type) {
            $this->elements[] = $element;
        } else {
            trigger_error("Element is not of the same type ('"
                .(gettype($element)=="object" ? get_class($element) : gettype($element))
                ."') as in the declaration ('".$this->type."'), skipped.", E_USER_WARNING);
            return false;
        }
        return true;
    }

    /**
     * Inserts the specified element at the specified position in this list.
     * @param string|int $index
     * @param $element
     * @return boolean
     */
    public function addAt($index, $element) {
        if(!is_null($index) && !is_null($element)) {
            if(is_string($index) && !$this->keepKeyCase) {
                $index = strtolower($index);
            }
            if(gettype($element) == $this->type || get_class($element) == $this->type) {
                $this->elements[$index] = $element;
            } else {
                trigger_error("Element at '".$index."' is not of the same type ('"
                    .(gettype($element)=="object" ? get_class($element) : gettype($element))
                    ."') as in the declaration ('".$this->type."'), skipped.", E_USER_WARNING);
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * Appends all of the elements in the specified Collection to the end of this list,
     * in the order that they are returned by the specified Collection's Iterator.
     * @param $elements
     * @return bool
     */
    public function addAll($elements) {
        if(!is_null($elements) && is_array($elements)) {
            foreach($elements as $key=>$element) {
                $this->addAt($key, $element);
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * Removes all of the elements from this list.
     * @return void
     */
    public function clear() {
        $this->elements = array();
    }

    /**
     * Returns true if this list contains the specified element.
     * @param $element
     * @return boolean
     */
    public function contains($element) {

        if(!is_null($element) && (gettype($element) == $this->type || get_class($element) == $this->type)) {
            foreach($this->elements as $key=>$elem) {
                if($elem === $element) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns true if this list contains the specified key.
     * @param int|string $index
     * @return bool
     */
    public function containsKey($index) {

        if(!is_null($index) && (is_int($index) || is_string($index))) {
            if($this->keepKeyCase) {
                $key = $index;
            } else {
                $key = strtolower($index);
            }

            if(array_key_exists($key, $this->elements)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the element at the specified position in this list.
     * @param int|string $index
     * @return $element|null
     */
    public function get($index) {
        if($this->keepKeyCase) {
           $key = $index;
        } else {
            $key = strtolower($index);
        }

        if(array_key_exists($key, $this->elements)) {
            return $this->elements[$key];
        } else {
            return null;
        }
    }

    /**
     * Searches for the first occurence of the given argument, testing for equality using the equals method.
     * @param Object $element
     * @return int | string | null
     */
    public function indexOf($element) {
        if(!is_null($element) && (gettype($element) == $this->type || get_class($element) == $this->type)) {
            foreach($this->elements as $key=>$elem) {
                if($elem === $element) {
                    return $key;
                }
            }
        }

        return null;
    }

    /**
     * Tests if this array has no elements.
     * @return boolean
     */
    public function isEmpty() {
        if(count($this->elements)==0) {
           return true;
        } else {
            return false;
        }
    }

    /**
     * Removes the element at the specified position in this list.
     * @param int | string $index
     * @return boolean
     */
    public function remove($index) {
        if(array_key_exists($index, $this->elements)) {
            unset($this->elements[$index]);
            return true;
        } else {
            return false;
        }
    }


    /**
     * Removes from this List all of the elements whose index is between fromIndex, inclusive and toIndex, exclusive.
     * @param int $fromIndex
     * @param int $toIndex
     * @return boolean
     */
    public function removeRange($fromIndex, $toIndex) {
        if(is_int($fromIndex) && is_int($toIndex) && $toIndex > $fromIndex) {
            for($i=$fromIndex;$i<$toIndex;$i++) {
                $this->remove($i);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Replaces the element at the specified position in this list with the specified element.
     * @param $index
     * @param $element
     * @return boolean
     */
    public function set($index, $element) {
        return $this->addAt($index, $element);
    }

    /**
     * Returns the number of elements in this list.
     * @return int
     */
    public function size() {
        return count($this->elements);
    }

    /**
     * Returns an array containing all of the elements in this list in the correct order.
     * @return array
     */
    public function toArray() {
        return $this->elements;
    }

    /**
     * Return the type given at declaration.
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Return true if the current ArrayCollection keeps the case of array keys.
     * @return boolean
     */
    public function isKeepingKeyCase() {
        return $this->keepKeyCase;
    }
}


