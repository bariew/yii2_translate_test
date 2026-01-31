<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project_to_translator}}`.
 */
class m260129_053249_create_project_to_translator_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project_to_translator}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'translator_id' => $this->integer(),
        ]);
        $this->addForeignKey('fk_project_id', '{{%project_to_translator}}', 'project_id', '{{%project}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_translator_id', '{{%project_to_translator}}', 'translator_id', '{{%project_translator}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project_to_translator}}');
    }
}
