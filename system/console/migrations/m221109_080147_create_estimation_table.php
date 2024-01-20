<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%estimation}}`.
 */
class m221109_080147_create_estimation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%estimation}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%estimation}}');
    }
}
