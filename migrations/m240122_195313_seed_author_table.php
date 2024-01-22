<?php

use yii\db\Migration;

/**
 * Данные для таблицы Авторы
 */
class m240122_195313_seed_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $this->insert(
                'author',
                [
                    'surname' => $faker->name,
                    'birth' => (int)$faker->year,
                    'biography' => $faker->text(100)
                ]
            );
        }
    }

}
