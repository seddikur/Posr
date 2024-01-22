<?php

use yii\db\Migration;

/**
 * Создание таблицы  `Статьи`.
 */
class m240122_190330_create_article_table extends Migration
{
    /**
     * Наименование таблицы, которая создается
     */
    const TABLE_NAME = 'article';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT "Статьи"';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull()->comment('Название'),
            'img' => $this->string(100)->comment('Картинка'),
            'preview' => $this->string(255)->comment('Анонс'),
            'text' => $this->text()->notNull()->comment('Текст'),
            'author_id' => $this->integer(11)->comment('id автора'),
        ], $tableOptions);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
