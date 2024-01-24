<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title Название
 * @property string|null $img Картинка
 * @property string|null $preview Анонс
 * @property string $text Текст
 * @property int|null $author_id id автора
 *
 * @property ArticleCategory[] $articleCategories
 */
class Article extends \yii\db\ActiveRecord
{

    /**
     * Вспомогательный атрибут для загрузки изображения
     */
    public $upload;

    /**
     *  Вспомогательный атрибут для категорий
     * @var array
     */
    public $categoryArray;

    /**
     * Возвращает имя таблицы базы данных
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * Правила валидации полей формы при создании и редактировании категории
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['author_id'], 'integer'],
            [['title', 'img'], 'string', 'max' => 100],
            [['preview'], 'string', 'max' => 255],
            //разрешить атрибуту заполняться во время массовых присвоений
            [['categoryArray',], 'safe'],
            // атрибут image проверяем с помощью валидатора image
            ['img', 'image', 'extensions' => 'png, jpg, gif'],
        ];
    }

    /**
     * пример http://localhost:8080/articles?fields=id,title&expand=author
     */
    public function extraFields()
    {
        return [
            'author',
        ];
    }

    /**
     * пример http://localhost:8080/articles?fields=id,title
     */
    public function fields()
    {
        return [
            'id',
            'title',
            'img',
            'preview',
            'text',
//            'author_id ',
        ];
    }

    /**
     * Возвращает имена полей формы для создания и редактирования категории
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'img' => 'Картинка',
            'preview' => 'Анонс',
            'text' => 'Текст',
            'author_id' => 'Автор',
        ];
    }

    /**
     * Загружает файл изображения
     */
    public function uploadImage() {
        if ($this->upload) { // только если был выбран файл для загрузки
            $name = md5(uniqid(rand(), true)) . '.' . $this->upload->extension;
            // сохраняем исходное изображение в директории source
            $source = Yii::getAlias('@webroot/images/article/source/' . $name);
            if ($this->upload->saveAs($source)) {
                // выполняем resize, чтобы получить маленькое изображение
                $thumb = Yii::getAlias('@webroot/images/article/thumb/' . $name);
                Image::thumbnail($source, 250, 250)->save($thumb, ['quality' => 90]);
                return $name;
            }
        }
        return false;
    }
    /**
     * Удаляет старое изображение при загрузке нового
     */
    public static function removeImage($name) {
        if (!empty($name)) {
            $source = Yii::getAlias('@webroot/images/article/source/' . $name);
            if (is_file($source)) {
                unlink($source);
            }
            $thumb = Yii::getAlias('@webroot/images/article/thumb/' . $name);
            if (is_file($thumb)) {
                unlink($thumb);
            }
        }
    }

    /**
     * Удаляет изображение при удалении статьи
     */
    public function afterDelete() {
        parent::afterDelete();
        self::removeImage($this->img);
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::class, ['article_id' => 'id']);
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Возвращает категории из связаных со статьей
     */
    public function getCategories(): array
    {
        return ArrayHelper::getColumn(
            $this->getArticleCategories()->all(), 'category_id');
    }
}
