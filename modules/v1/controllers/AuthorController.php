<?php

namespace app\modules\v1\controllers;

class AuthorController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Author';

    private function errorResponse($message)
    {
        // set response code to 400
        \Yii::$app->response->statusCode = 400;

        return $this->asJson(['error' => $message]);
    }
}

