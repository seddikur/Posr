<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

    <fieldset>
        <legend>Загрузить изображение</legend>
        <?= $form->field($model, 'img')->fileInput(); ?>
        <?php
        if (!empty($model->img)) {
            $img = Yii::getAlias('@webroot') . '/images/categories/source/' . $model->img;
            if (is_file($img)) {
                $url = Yii::getAlias('@web') . '/images/categories/source/' . $model->img;
                echo 'Уже загружено ', Html::a('изображение', $url, ['target' => '_blank']);
            }
        }
        ?>
    </fieldset>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
