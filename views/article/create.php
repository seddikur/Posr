<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var \app\models\Author $authors Авторы */
/** @var \app\models\Category $category Категории */

$this->title = 'Новая статья';
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors,
        'category' => $category,
    ]) ?>

</div>
