<?php

namespace MyTestApp\projects\web\Managers;

use IonXLab\IonXApi\builtin\base\BaseManager;
use IonXLab\projects\web\Controllers\ArticleController;

class ArticleMgr extends BaseManager {

    private $articleController;

    public function __construct() {
        parent::__construct("IonXLab\\projects\\web\\Models\\Article", new ArticleController());
    }

    /**
     * POST a new Article
     *
     * @api {post} /web/articles Create a new Article
     * @apiName PostArticle
     * @apiGroup Article
     *
     * @apiVersion 0.5.0
     *
     * @apiParam {Json} Article Object.
     *     	{
     *     	}
     *
     * @apiSuccess {Json} Article Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *     	}
     *
     * @apiError ArticleConflict The given Article exists.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 409 Conflict
     */
    public function postArticle($json) {
        return $this->postObject($json);
    }

    /**
     * GET Article
     *
     * @api {get} /web/articles/$id Request Article
     * @apiName GetArticle
     * @apiGroup Article
     *
     * @apiVersion 0.5.0
     *
     * @apiParam {Number} id Articles unique ID.
     *
     * @apiSuccess {Json} Article Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *     	}
     *
     * @apiError ArticleNotFound The id of the Article was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function getArticle($id) {
        return $this->getObject($id);
    }

    /**
     * GET Articles
     *
     * @api {get} /web/articles Request Articles
     * @apiName GetArticles
     * @apiGroup Article
     *
     * @apiVersion 0.5.0
     *
     * @apiSuccess {array(Json)} array(Article) Object.
     *
     * @apiSuccessExample Success-Response:
     * 		HTTP/1.1 200 OK
     *     	{
     *     	}
     *
     * @apiError ArticleNotFound No Article was found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     */
    public function getArticles() {
        return $this->getObjects();
    }

    public function putArticle($id, $json) {
        $this->putObject($id, $json);
    }

    public function deleteArticle($id) {
        return $this->deleteObject($id);
    }

}
