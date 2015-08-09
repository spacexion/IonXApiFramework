<?php

namespace IonXApi\builtin\controllers;

use IonXApi\builtin\base\BaseController;
use IonXApi\builtin\models\User;
use IonXApi\EntityMgr;

class UserController extends BaseController {

    public function __construct() {
        parent::__construct("User");
    }

    /**
     * Create the user
     * @param User $user
     * @return User or NULL
     */
    public function createUser($user) {
        if ($user->getEmail() != null) {
            if ($this->repository->findOneByEmail($user->getEmail()) == null) {

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return $this->repository->findOneByEmail($user->getEmail());
            }
        }
        return null;
    }

    /**
     * Read User information
     * @param int $id the user id
     * @return User or NULL
     */
    public function readUser($id) {
        return $this->read($id);
    }

    /**
     * Read User information with its email
     * @param string $email the user email
     * @return User or NULL
     */
    public function readUserByEmail($email) {
        $user = $this->repository->findOneByEmail($email);
        return $user;
    }

    /**
     * Read User information with its email and password
     * @param string $email the user email
     * @param string $password the user password
     * @return User or NULL
     */
    public function readUserByEmailAndPassword($email, $password) {
        $user = $this->repository->findOneBy(array("email" => $email, "password" => $password));
        return $user;
    }

    /**
     * Read all Users informations
     * @return array(User) or NULL
     */
    public function readUsers($limit = 50, $offset = 0, $sort = "", $query = "") {
        return $this->readObjects($limit, $offset, $sort, $query);
    }

    /**
     * Update User informations
     * @param User $user the user to update
     * @return User or NULL
     */
    public function updateUser($user) {
        return $this->update($user, false);
    }

    /**
     * Update array(User) informations
     * @param array(User) $user the users to update
     * @return array(User) or NULL
     */
    public function updateUsers($users) {
        return $this->updateObjects($users);
    }

    /**
     * Delete User
     * @param int $id the user id to delete
     * @return 0:success, 1:not found, 2:fail
     */
    public function deleteUser($id) {
        return $this->delete($id);
    }

}

?>