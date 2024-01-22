<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string $surname Фамилия И.О.
 * @property int $birth Год рождения
 * @property string|null $biography Биография
 */
class Author extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['surname', 'birth'], 'required'],
            [['birth'], 'integer'],
            [['surname'], 'string', 'max' => 100],
            [['biography'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'surname' => 'Фамилия И.О.',
            'birth' => 'Год рождения',
            'biography' => 'Биография',
        ];
    }
}
