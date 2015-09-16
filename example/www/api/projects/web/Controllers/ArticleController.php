<?php
namespace MyTestApp\projects\web\Controllers;

use IonXLab\IonXApi\builtin\base\BaseController;
use IonXLab\IonXApi\util\EntityMgr;

class ArticleController extends BaseController {

    public function __construct() {
        $this->entityManager = EntityMgr::$entityManager;
        $this->repository = $this->entityManager->getRepository('MyTestApp\projects\web\Models\Article');
    }

    public function createArticle($article) {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    public function readArticle($id) {
        $article = $this->repository->find($id);
        return $article;
    }

    public function readArticleByName($authName) {
        $article = $this->repository->findOneByAuthName($authName);
        return $article;
    }

    public function readArticles() {
        $articles = $this->repository->findAll();
        return $articles;
    }

    public function updateArticle($article) {
        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }

    public function updateArticles($articles) {
        
    }

    public function deleteArticle($article) {
        if ($article != null) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();
        }
    }

}

?>