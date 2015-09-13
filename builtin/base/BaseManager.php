<?php

namespace IonXLab\IonXApi\builtin\base;
use IonXLab\IonXApi\network\ApiResponse;
use IonXLab\JacksonPhp\databind\ObjectMapper;

/**
 * The Base Class for API Managers
 * @author Nicolas Gezequel
 */
class BaseMgr {

    /**
     * @var string the controller class name
     */
    protected $controller;
    /**
     * @var string the managed object name
     */
    protected $entityName;

    /**
     * @param $entityName string the controller class name
     * @param $controller string the managed object name
     */
    public function __construct($entityName, $controller) {
        $this->entityName = $entityName;
        $this->controller = $controller;
    }

    /**
     * POST a new Object
     * @param Json String the received Json Data String
     * @param string $controllerMethod
     * @return boolean success
     */
    protected function postObject($json, $controllerMethod = "create") {
        $objectJson = json_decode($json);
        $mapper = new ObjectMapper();
        $object = $mapper->readValue($objectJson, new $this->entityName());

        if($object==null) {
            ApiResponse::getInstance()->setResponseError(404);
            return false;
        }

        $newObject = $this->controller->$controllerMethod($object);

        if ($newObject == null) {
            ApiResponse::getInstance()->setResponseError(409);
            return false;
        } else {
            ApiResponse::getInstance()->setBody($mapper->writeValue($newObject));
            return true;
        }
    }

    /**
     * GET an Object by its id
     * @param int the object id
     * @param string $controllerMethod
     * @return boolean success
     */
    protected function getObject($id, $controllerMethod = "read") {
        $object = $this->controller->$controllerMethod($id);

        if ($object == null) {
            ApiResponse::getInstance()->setResponseError(404);
            return false;
        } else {
            ApiResponse::getInstance()->setBody((new ObjectMapper())->writeValue($object));
            return true;
        }
    }

    /**
     * GET array of Objects
     * @param int $limit
     * @param int $offset
     * @param string $sort
     * @param string $query
     * @param string $controllerMethod
     * @return boolean success
     */
    protected function getObjects($limit = 50, $offset = 0, $sort = "", $query = "", $controllerMethod = "reads") {
        $objects = $this->controller->$controllerMethod($limit, $offset, $sort, $query);
        if ($objects == null) {
            ApiResponse::getInstance()->setResponseError(404);
            return false;
        } else {
            $mapper = new ObjectMapper();
            $array = array();
            foreach ($objects as $object) {
                $array[] = $mapper->writeValue($object);
            }
            ApiResponse::getInstance()->setBody(json_encode($array));
            return true;
        }
    }

    /**
     * PUT update an Object
     * @param $id
     * @param $json
     * @param string $controllerMethod
     * @return bool success
     * @internal param bool $checkEmptyVars
     * @internal param String $Json the received Json Data String
     */
    protected function putObject($id, $json, $controllerMethod = "update") {
        $objectJson = json_decode($json);
        $mapper = new ObjectMapper();
        $object = $mapper->readValue($objectJson, new $this->entityName());
        $object->setId($id);

        $newObject = $this->controller->$controllerMethod($object);
        if ($newObject == null) {
            ApiResponse::getInstance()->setResponseError(404);
            return false;
        } else {
            ApiResponse::getInstance()->setBody((new ObjectMapper())->writeValue($object));
            return true;
        }
    }

    /**
     * DELETE an Object
     * @param int $id the object id
     * @param string $controllerMethod the controllerMethod name to use
     * @return bool success
     */
    protected function deleteObject($id, $controllerMethod = "delete") {
        $result = $this->controller->$controllerMethod($id);

        switch ($result) {
            case 0:
                ApiResponse::getInstance()->setResponseError(200);
                return true;
                break;
            case 1:
                ApiResponse::getInstance()->setResponseError(404);
                return false;
                break;
            case 2:
                ApiResponse::getInstance()->setResponseError(500);
                return false;
                break;
            default:
                return false;
                break;
        }
    }
}

?>