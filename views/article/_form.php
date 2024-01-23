<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
/** @var \app\models\Author $authors Авторы */
/** @var \app\models\Category $category Категории */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

    <?
    echo $form->field($model, 'categoryArray')->widget(Select2::className(), [
        'data' => ArrayHelper::map($category, 'id', 'title'),
        'language' => 'ru',
        'options' => ['placeholder' => 'Выбери категорию ...',
            'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'maximumInputLength' => 5
        ],])->label('Категории');
    ?>

    <fieldset>
        <legend>Загрузить изображение</legend>
        <?= $form->field($model, 'img')->fileInput(); ?>
        <?php
        if (!empty($model->img)) {
            $img = Yii::getAlias('@webroot') . '/images/article/source/' . $model->img;
            if (is_file($img)) {
                $url = Yii::getAlias('@web') . '/images/article/source/' . $model->img;
                echo 'Уже загружено ', Html::a('изображение', $url, ['target' => '_blank']);
            }
        }
        ?>
    </fieldset>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'author_id')->dropDownList($authors) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
