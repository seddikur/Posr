<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php // при редактировании существующей категории нельзя допустить, чтобы
    // в качестве родителя была выбрана эта же категория или ее потомок
    $exclude = 0;
    if (!empty($model->id)) {
        $exclude = $model->id;
        $parents = $model::getTree($exclude, true);
        echo $form->field($model, 'parent_id')->dropDownList($parents);
    }?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
