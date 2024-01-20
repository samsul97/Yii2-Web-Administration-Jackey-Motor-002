<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074855_tbinvpoparent extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%tbinvpoparent}}',
            [
                'id'=> $this->primaryKey(11),
                'id_user'=> $this->integer(11)->notNull(),
                'no_transaction'=> $this->string(50)->notNull(),
                'purchase_number_parent'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tbinvpoparent}}');
    }
}
