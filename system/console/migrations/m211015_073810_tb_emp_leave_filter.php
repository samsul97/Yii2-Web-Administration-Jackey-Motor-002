<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073810_tb_emp_leave_filter extends Migration
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
            '{{%tb_emp_leave_filter}}',
            [
                'id'=> $this->primaryKey(11),
                'id_employee'=> $this->integer(11)->notNull(),
                'leave_years'=> $this->date(4)->notNull(),
                'leave_total'=> $this->integer(11)->notNull()->defaultValue(0),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_leave_filter}}');
    }
}
