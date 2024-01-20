<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074020_tb_emp_shift extends Migration
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
            '{{%tb_emp_shift}}',
            [
                'id'=> $this->primaryKey(11),
                'description'=> $this->string(255)->notNull(),
                'clock_in'=> $this->time()->notNull(),
                'clock_out'=> $this->time()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_shift}}');
    }
}
