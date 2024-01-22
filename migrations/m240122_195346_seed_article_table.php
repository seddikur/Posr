<?php

use yii\db\Migration;

/**
 * Данные для таблицы Статьи
 */
class m240122_195346_seed_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $this->insert(
                'article',
                [
                    'title' => $faker->name,
                    'preview' => $faker->text(rand(100, 200)),
                    'text' => $faker->text(rand(1000, 2000)),
//                    'img' => $faker->fileExtension(),
                    'img' => $faker->filePath(),
                ]
            );
        }
    }

}
