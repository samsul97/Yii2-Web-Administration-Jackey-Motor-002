<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%mechanic}}`.
 */
class m221109_080217_create_mechanic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%mechanic}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%mechanic}}');
    }
}
