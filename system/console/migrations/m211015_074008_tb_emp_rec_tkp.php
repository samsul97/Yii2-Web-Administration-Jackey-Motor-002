<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074008_tb_emp_rec_tkp extends Migration
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
            '{{%tb_emp_rec_tkp}}',
            [
                'id'=> $this->primaryKey(11),
                'id_employee'=> $this->integer(11)->notNull(),
                'id_tkp_origin'=> $this->integer(11)->notNull(),
                'id_tkp_destination'=> $this->integer(11)->notNull(),
                'dot'=> $this->datetime()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_rec_tkp}}');
    }
}
