<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073648_tb_emp_attendance extends Migration
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
            '{{%tb_emp_attendance}}',
            [
                'id'=> $this->primaryKey(10)->unsigned(),
                'id_user'=> $this->integer(10)->notNull(),
                'id_shift'=> $this->string(255)->notNull(),
                'tgl'=> $this->date()->notNull(),
                'in_out'=> $this->string(255)->notNull(),
                'time'=> $this->time()->notNull(),
                'accurancy'=> $this->string(255)->notNull(),
                'location'=> $this->string(255)->notNull(),
                'description'=> $this->text()->notNull(),
                'image'=> $this->string(255)->notNull(),
                'created_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'updated_at'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_attendance}}');
    }
}
