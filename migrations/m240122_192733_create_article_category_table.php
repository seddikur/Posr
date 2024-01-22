<?php

use yii\db\Migration;

/**
 * Создание таблицы  `Статьи-Категории`.
 */
class m240122_192733_create_article_category_table extends Migration
{
    /**
     * Наименование таблицы, которая создается
     */
    const TABLE_NAME = 'article_category';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT "Статьи-Категории"';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(11)->notNull()->comment('id категории'),
            'article_id' => $this->integer(11)->notNull()->comment('id статьи')
        ], $tableOptions);

        $this->createIndex(
            'category_id',
            'article_category',
            'category_id'
        );

        $this->createIndex(
            'article_id',
            'article_category',
            'article_id'
        );

        $this->addForeignKey(
            'fk_article_category_id',
            'article_category',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_category_article_id',
            'article_category',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_category_id', 'article_category');
        $this->dropForeignKey('fk_category_article_id', 'article_category');
        $this->dropIndex('category_id', 'article_category');
        $this->dropIndex('article_id', 'article_category');
        $this->dropTable(self::TABLE_NAME);
    }
}
