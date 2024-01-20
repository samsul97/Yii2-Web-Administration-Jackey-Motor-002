<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074659_tb_pur_pro_ingredients extends Migration
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
            '{{%tb_pur_pro_ingredients}}',
            [
                'id'=> $this->primaryKey(11),
                'id_pur_pro'=> $this->integer(11)->notNull(),
                'id_ingredients'=> $this->integer(11)->notNull(),
                'qty'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_pur_pro_ingredients}}');
    }
}
