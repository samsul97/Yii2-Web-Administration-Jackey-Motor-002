<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072425_mr_in_ingredients extends Migration
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
            '{{%mr_in_ingredients}}',
            [
                'id'=> $this->primaryKey(11),
                'id_supplier'=> $this->integer(11)->notNull(),
                'id_in_unit'=> $this->integer(11)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_in_ingredients}}');
    }
}
