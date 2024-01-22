<?php

use yii\db\Migration;

/**
 * Данные для таблицы Категории
 */
class m240122_195327_seed_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $this->insert(
                'category',
                [
                    'title' => $faker->domainWord,
                    'description' => $faker->text(50),
                    'parent_id' => $faker->numberBetween(0, 3)
                ]
            );
        }
    }

}

