<?php

namespace IonXApi\builtin\models;

use IonXApi\builtin\base\BaseModel;

/**
 * @Entity
 * @Table(name="users")
 **/
class User extends BaseModel {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    private $firstname = "";

    /**
     * @Column(type="string", length=128)
     * @var string
     */
    private $lastname = "";

    /**
     * @Column(type="string", length=512, nullable=false)
     * @var string
     * @required
     */
    private $password = "";

    /**
     * @Column(type="string", length=128, unique=true, nullable=false)
     * @var string
     * @required
     */
    private $username = "";

    /**
     * @Column(type="string", length=128, unique=true, nullable=false)
     * @var string
     * @required
     */
    private $email = "";

    /**
     * @Column(type="integer")
     * @var int
     */
    private $authLevel = 1;

    public function __construct() {
        
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return int authLevel
     */
    public function getAuthLevel() {
        return $this->authLevel;
    }

    /**
     * @param int authLevel
     */
    public function setAuthLevel($authLevel) {
        $this->authLevel = $authLevel;
    }

    /**
     * Return Array of current object parameters
     * @return array
     */
    public function toArray($array = array()) {
        return parent::toArray(get_object_vars($this));
    }

    /**
     * Set the current object parameters with given array
     *  @param array the array to use to set the parameters
     */
    public function setFromArray($array) {
        parent::setFromArray($array);
    }

    /**
     * Return an array with rw permission on each properties of the model
     * Example:read,write for everyone
     * $array["property"] = array(0,0);
     * @return array
     */
    public function getPermissions($null = 0, $array = array()) {
        $array = parent::toArray(get_object_vars($this));
        $array["authLevel"] = array(0, 5);
        return $array;
    }

}

?>