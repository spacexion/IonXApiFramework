<?php

namespace com\ionxlab\ionxapi\builtin\base;

/**
 * The Base Class for API Managers
 * @author Nicolas Gezequel
 */
class BaseMgr
{

    protected $controller;
    protected $entityName;

    public function __construct($entityName, $controller)
    {
        $this->entityName = $entityName;
        $this->controller = $controller;
    }

    /**
     * POST a new Object
     * @param Json String the received Json Data String
     * @param string $controllerMethod
     * @return boolean success
     */
    protected function postObject($json, $controllerMethod = "create")
    {
        $objectJson = json_decode($json);
        $mapper = new JsonMapper();
        $object = $mapper->map($objectJson, new $this->entityName());

        $newObject = $this->controller->$controllerMethod($object);

        if ($newObject == null) {
            ApiHttpResponse::setHttpStatusCode(409);
            return false;
        } else {
            ApiHttpResponse::setContent(json_encode($newObject->toArray()));
            return true;
        }
    }

    /**
     * GET an Object by its id
     * @param int the object id
     * @param string $controllerMethod
     * @return boolean success
     */
    protected function getObject($id, $controllerMethod = "read")
    {
        $object = $this->controller->$controllerMethod($id);

        if ($object == null) {
            ApiHttpResponse::setHttpStatusCode(404);
            return false;
        } else {
            ApiHttpResponse::setContent(json_encode($object->toArray()));
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
     * @internal param the $int limit
     * @internal param the $int offset
     * @internal param the $string orderby (-name)
     * @internal param the $string where clause
     * @return boolean success
     */
    protected function getObjects($limit = 50, $offset = 0, $sort = "", $query = "", $controllerMethod = "reads")
    {
        $objects = $this->controller->$controllerMethod($limit, $offset, $sort, $query);
        if ($objects == null) {
            ApiHttpResponse::setHttpStatusCode(404);
            return false;
        } else {
            foreach ($objects as $value) {
                $array[] = $value->toArray();
            }
            ApiHttpResponse::setContent(json_encode($array));
            return true;
        }
    }

    /**
     * PUT update an Object
     * @param $id
     * @param $json
     * @param string $controllerMethod
     * @param bool $checkEmptyVars
     * @internal param String $Json the received Json Data String
     * @return boolean success
     */
    protected function putObject($id, $json, $controllerMethod = "update", $checkEmptyVars = true)
    {
        $objectJson = json_decode($json);
        $mapper = new JsonMapper();
        $object = $mapper->map($objectJson, new $this->entityName());
        $object->setId($id);

        $newObject = $this->controller->$controllerMethod($object);
        if ($newObject == null) {
            ApiHttpResponse::setHttpStatusCode(404);
            return false;
        } else {
            ApiHttpResponse::setContent(json_encode($newObject->toArray()));
            return true;
        }
    }

    /**
     * DELETE an Object
     * @param int the object id
     * @return boolean success
     */
    protected function deleteObject($id, $controllerMethod = "delete")
    {
        $result = $this->controller->$controllerMethod($id);

        switch ($result) {
            case 0:
                ApiHttpResponse::setHttpStatusCode(200);
                return true;
                break;
            case 1:
                ApiHttpResponse::setHttpStatusCode(404);
                return false;
                break;
            case 2:
                ApiHttpResponse::setHttpStatusCode(500);
                return false;
                break;
            default:
                return false;
                break;
        }
    }

}

?>