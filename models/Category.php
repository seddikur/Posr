<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title Название
 * @property string $description Описание
 * @property int|null $parent_id Родитель категории
 *
 * @property ArticleCategory[] $articleCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * Возвращает имя таблицы базы данных
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * Возвращает данные о родительской категории
     */
    public function getParent() {
        return $this->hasOne(Category::class, ['id' => 'parent_id']);
    }

    /**
     * Правила валидации полей формы при создании и редактировании категории
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['parent_id'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
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
            'description' => 'Описание',
            'parent_id' => 'Родитель категории',
        ];
    }

    /**
     * Возвращает массив всех категорий каталога в виде дерева
     */
    public static function getAllCategories($parent = 0, $level = 0, $exclude = 0) {
        $children = self::find()
            ->where(['parent_id' => $parent])
            ->asArray()
            ->all();
        $result = [];
        foreach ($children as $category) {
            // при выборе родителя категории нельзя допустить
            // чтобы она размещалась внутри самой себя
            if ($category['id'] == $exclude) {
                continue;
            }
            if ($level) {
                $category['title'] = str_repeat('— ', $level) . $category['title'];
            }
            $result[] = $category;
            $result = array_merge(
                $result,
                self::getAllCategories($category['id'], $level+1, $exclude)
            );
        }
        return $result;
    }

    /**
     * Возвращает массив всех категорий каталога для возможности
     * выбора родителя при добавлении или редактировании товара
     * или категории
     */
    public static function getTree($exclude = 0, $root = false) {
        $data = self::getAllCategories(0, 0, $exclude);
        $tree = [];
        // при выборе родителя категории можно выбрать значение
        // «Без родителя» — это будет категория верхнего уровня
        if ($root) {
            $tree[0] = 'Без родителя';
        }
        foreach ($data as $item) {
            $tree[$item['id']] = $item['title'];
        }
        return $tree;
    }

    /**
     * Возвращает массив идентификаторов всех потомков категории $id,
     * т.е. дочерние, дочерние дочерних и так далее
     */
    public static function getAllChildIds($id) {
        $children = [];
        $ids = self::getChildIds($id);
        foreach ($ids as $item) {
            $children[] = $item;
            $c = self::getAllChildIds($item);
            foreach ($c as $v) {
                $children[] = $v;
            }
        }
        return $children;
    }

    /**
     * Возвращает массив идентификаторов дочерних категорий (прямых
     * потомков) категории с уникальным идентификатором $id
     */
    protected static function getChildIds($id) {
        $children = self::find()->where(['parent_id' => $id])->asArray()->all();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child['id'];
        }
        return $ids;
    }

    /**
     * Проверка перед удалением категории
     */
    public function beforeDelete() {
        $children = self::find()->where(['parent_id' => $this->id])->all();
        $products = ArticleCategory::find()->where(['category_id' => $this->id])->all();
        if (!empty($children) || !empty($products)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить категорию, которая имеет статьи или дочерние категории'
            );
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Gets query for [[ArticleCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::class, ['category_id' => 'id']);
    }
}
