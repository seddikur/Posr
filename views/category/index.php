<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var Category $categories */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новая Категория', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <? GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',
            'parent_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Наименование</th>
            <th> Описание</th>
            <th><?=$this->context->iconList?></span></th>
            <th><?=$this->context->iconEyeOpen?></th>
            <th><?=$this->context->iconPencil?></span></th>
            <th><?=$this->context->iconTrash?></span></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['title']; ?></td>
                <td><?= $category['description']; ?></td>
                <td>
                    <?php
                    echo Html::a(
                        $this->context->iconList,
                        ['/category/article', 'id' => $category['id']]
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo Html::a(
                        $this->context->iconEyeOpen,
                        ['/category/view', 'id' => $category['id']]
                    );
                    ?>
                </td>
                <td>
                    <?php

                    echo Html::a(
                        $this->context->iconPencil,
                        ['/category/update', 'id' => $category['id']]
                    );
                    ?>
                </td>
                <td>
                    <?php
                    echo Html::a(
                        $this->context->iconTrash,
                        ['/admin/category/delete', 'id' => $category['id']],
                        [
                            'data-confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                            'data-method' => 'post'
                        ]
                    );
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


</div>
