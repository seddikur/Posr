<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var \app\models\Author $authors Авторы */
/** @var \app\models\Category $category Категории */

$this->title = 'Изменить статью: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
        'category' => $category,
    ]) ?>

</div>
