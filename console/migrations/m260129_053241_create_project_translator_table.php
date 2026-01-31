<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_translator}}`.
 */
class m260129_053241_create_project_translator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_translator}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'availability' => $this->smallInteger(1),
        ]);
        foreach (range(1,10) as $number) {
            $this->insert('{{%project_translator}}', [
                'name' => "Name N".$number,
                'availability' => rand(0,2)
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project_translator}}');
    }
}
