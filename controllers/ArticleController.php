<?php

namespace app\controllers;

use app\models\Article;
use app\models\ArticleCategory;
use app\models\Author;
use app\models\Category;
use app\models\search\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * Класс ArticleController реализует CRUD для категорий
 */

class ArticleController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Список всех статей
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Просмотр данных существующей категории
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Article();
        $array= Author::find()->all();
        $authors = ArrayHelper::map($array, 'id', 'surname');
        //показываем какие теги записаны для этой статьи
        $model->categoryArray = $model->getCategories();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            // загружаем изображение и выполняем resize исходного изображения
            $model->upload = UploadedFile::getInstance($model, 'img');
            if ($name = $model->uploadImage()) { // если изображение было загружено
                // сохраняем в БД имя файла изображения
                $model->image = $name;
            }
            if($model->save()){
                //запись категории
                //удаляем сначала все категории по этой статье
                ArticleCategory::deleteAll(['article_id' => $model->id]);
                $values = [];
                //получаем из формы атрибут categoryArray
                $model->categoryArray;
                foreach ($model->categoryArray as $id) {
                    $values[] = [$model->id, $id];
                }
                //записываем массив в таблицу
                \Yii::$app->db->createCommand()->batchInsert(ArticleCategory::tableName(), ['article_id', 'category_id'], $values)->execute();
                return $this->redirect(['index']);
            }else{
                echo \yii\helpers\Json::encode($model->getErrors());
                die();
            }
        }
        return $this->render('create', [
            'model' => $model,
            'authors' => $authors,
            'category' => Category::find()->all(),
        ]);

    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $array= Author::find()->all();
        $authors = ArrayHelper::map($array, 'id', 'surname');
        //показываем какие теги записаны для этой статьи
        $model->categoryArray = $model->getCategories();

        // старое изображение, которое надо удалить, если загружено новое
        $old = $model->img;
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            // загружаем изображение и выполняем resize исходного изображения
            $model->upload = UploadedFile::getInstance($model, 'img');
            if ($new = $model->uploadImage()) { // если изображение было загружено
                // удаляем старое изображение
                if (!empty($old)) {
                    $model::removeImage($old);
                }
                // сохраняем в БД новое имя
                $model->img = $new;
            } else { // оставляем старое изображение
                $model->img = $old;
            }

            if($model->save()){
                //запись категории
                //удаляем сначала все категории по этой статье
                ArticleCategory::deleteAll(['article_id' => $model->id]);
                $values = [];
                //получаем из формы атрибут categoryArray
                $model->categoryArray;
                foreach ($model->categoryArray as $id) {
                    $values[] = [$model->id, $id];
                }
                //записываем массив в таблицу
                \Yii::$app->db->createCommand()->batchInsert(ArticleCategory::tableName(), ['article_id', 'category_id'], $values)->execute();
                return $this->redirect(['index']);
            }else{
                echo \yii\helpers\Json::encode($model->getErrors());
                die();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'authors' => $authors,
            'category' => Category::find()->all(),
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
