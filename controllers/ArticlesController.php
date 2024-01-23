<?php

namespace app\controllers;

use app\models\Article;

class ArticlesController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Article';

    private function errorResponse($message)
    {
        // set response code to 400
        \Yii::$app->response->statusCode = 400;

        return $this->asJson(['error' => $message]);
    }

    //1.Список статей
    public function actionArticles()
    {
        $author_article = Article::find()->all();
        return $this->asJson($author_article);
    }

    //2.Поиск статей по автору (id)
    public function actionAuthorArticles($author_id)
    {
        $author_article = Article::find()
            ->leftJoin('author', 'article.author_id=author.id')
            ->where(['article.author_id' => $author_id])->all();
        return $this->asJson($author_article);
    }

    //2.Поиск статей по категории (id)
    public function actionCategoryArticles($author_id)
    {
//        $author_article = Article::find()
//            ->leftJoin('category', 'article.author_id=author.id')
//            ->where(['article.author_id' => $author_id])->all();
//        return $this->asJson($author_article);
    }


}
