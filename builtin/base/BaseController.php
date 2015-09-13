<?php

namespace IonXLab\IonXApi\builtin\base;
use IonXLab\IonXApi\util\EntityMgr;
use IonXLab\JacksonPhp\databind\ObjectParser;

/**
 * The Base Class for API Controllers
 * @author Nicolas Gézéquel
 */
class BaseController {

    protected $repository;
    protected $entityManager;

    public function __construct($repositoryName) {
        $this->entityManager = EntityMgr::$entityManager;
        $this->repository = $this->entityManager->getRepository($repositoryName);
    }

    /**
     * Create the object
     * @param Object $object
     * @return Object or NULL
     */
    public function create($object) {
        if (is_object($object)) {
            $this->entityManager->persist($object);
            $this->entityManager->flush();
            return $this->read($object->getId());
        }
        return null;
    }

    /**
     * Read Object information
     * @param int $id the object id
     * @return Object or NULL
     */
    public function read($id) {
        $object = $this->repository->find($id);
        return $object;
    }

    /**
     * Read all Objects informations
     * @param int $limit the max number of elements in the array
     * @param int $offset the element number to start the array
     * @param string $sort the order by in form "-name" for "ORDER BY 'name' DESC"
     * @param array $query Associative array for where clause ("level"=>15,...)
     * @return array(Object) or NULL
     */
    public function reads($limit = 50, $offset = 0, $sort = "", $query = array()) {
        $orderby = array();
        if ($sort != "") {
            //DESC
            if ($sort[0] == '-') {
                $orderby[substr($sort, 1, strlen($sort) - 1)] = "DESC";
                //ASC
            } else {
                $orderby[$sort] = "ASC";
            }
        }
        $objects = $this->repository->findBy(
                array(), // $where
                $orderby, // $orderBy
                $limit, // $limit
                $offset  // $offset
        );

        return $objects;
    }

    /**
     * Update Object informations
     * @param Object $object the object to update
     * @return Object or NULL
     */
    public function update($object, $checkEmptyVars = true) {
        if (is_object($object) && $object->getId() !== null && $object->getId() != null) {
            $objectDB = $this->read($object->getId());
            if ($objectDB != null) {
                if ($checkEmptyVars) {
                    foreach ($object->toArray() as $var => $value) {
                        if ($value == null) {
                            $set = "set" . ucfirst($var);
                            $get = "get" . ucfirst($var);
                            $object->$set($objectDB->$get());
                        }
                    }
                }
                $this->entityManager->merge($object);
                $this->entityManager->flush();

                $newObjectDB = $this->read($object->getId());
                return $newObjectDB;
            }
        }
        return null;
    }

    /**
     * Update array of Object values
     * @param Object[] $objects the objects to update
     * @param bool $checkEmptyVars check if vars in object are empty
     * @return NULL|Object[]
     */
    public function updates($objects, $checkEmptyVars = false) {
        if (is_array($objects)) {
            $result = array();
            foreach ($objects as $object) {
                $objectDB = $this->read($object->getId());
                if ($objectDB != null) {
                    if ($checkEmptyVars) {
                        foreach ((new ObjectParser())->parseObject($object) as $var) {
                            if ($var->getValue() == null) {
                                $set = $var->getSetter();
                                $get = $var->getGetter();
                                $object->$set($objectDB->$get());
                            }
                        }
                    }
                    $this->entityManager->merge($object);
                    $this->entityManager->flush();
                    $this->entityManager->clear();

                    $result[] = $this->read($object->getId());
                }
            }
            if (count($result) > 0) {
                return $result;
            }
        }
        return null;
    }

    /**
     * Delete Object
     * @param int $id the object id to delete
     * @return int 0:success, 1:not found, 2:fail
     */
    public function delete($id) {
        $object = $this->read($id);
        if ($object != NULL) {
            $this->entityManager->remove($object);
            $this->entityManager->flush();

            $checkObject = $this->read($id);
            if ($checkObject == NULL) {
                return 0;
            }
            return 2;
        }
        return 1;
    }

}

?>