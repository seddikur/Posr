<?php

use yii\db\Migration;

/**
 * Создание таблицы  `Авторы`.
 */
class m240122_190247_create_author_table extends Migration
{
    /**
     * Наименование таблицы, которая создается
     */
    const TABLE_NAME = 'author';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT "Авторы"';
        }
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'surname' => $this->string(100)->notNull()->comment('Фамилия И.О.'),
            'birth' => $this->integer(50)->notNull()->comment('Год рождения'),
            'biography' => $this->string(255)->comment('Биография'),
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
