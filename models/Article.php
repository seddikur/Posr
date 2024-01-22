<?php

namespace app\models;

use Yii;

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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['author_id'], 'integer'],
            [['title', 'img'], 'string', 'max' => 100],
            [['preview'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'img' => 'Картинка',
            'preview' => 'Анонс',
            'text' => 'Текст',
            'author_id' => 'id автора',
        ];
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
}
