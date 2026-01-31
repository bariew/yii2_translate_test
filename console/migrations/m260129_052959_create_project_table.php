<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m260129_052959_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->text(),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression('NOW()')),
        ]);
        foreach ([1,2,3, 4, 5] as $number) {
            $this->insert('{{%project}}', [
                'title' => "Project N".$number,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project}}');
    }
}
