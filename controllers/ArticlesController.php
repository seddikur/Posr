<?php

namespace app\controllers;

use app\models\Article;
use yii\rest\ActiveController;

class ArticlesController extends ActiveController
{

    public $modelClass = 'app\models\Article';

    private function errorResponse($message)
    {
        // set response code to 400
        \Yii::$app->response->statusCode = 400;

        return $this->asJson(['error' => $message]);
    }



}
