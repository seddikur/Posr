<?php

use yii\db\Migration;

/**
 * Создание таблицы  `Категории`.
 */
class m240122_190427_create_category_table extends Migration
{

    /**
     * Наименование таблицы, которая создается
     */
    const TABLE_NAME = 'category';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT "Категории"';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull()->comment('Название'),
            'description' => $this->string(255)->notNull()->comment('Описание'),
            'parent_id' => $this->integer()->comment('Родитель категории'),
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
