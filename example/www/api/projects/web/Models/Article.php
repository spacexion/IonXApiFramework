<?php

namespace MyTestApp\projects\web\Models;

use IonXLab\IonXApi\builtin\base\BaseModel;

/**
 * @Entity @Table(name="articles")
 * */
class Article extends BaseModel {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title = "";

    /**
     * @Column(type="text")
     * @var string
     */
    private $content = "";

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
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content) {
        $this->content = $content;
    }
}

?>