<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074823_tbinvpochild extends Migration
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
            '{{%tbinvpochild}}',
            [
                'id'=> $this->primaryKey(11),
                'id_inv_po_parent'=> $this->integer(11)->notNull(),
                'id_tkp'=> $this->integer(11)->notNull(),
                'purchase_number_child'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tbinvpochild}}');
    }
}
