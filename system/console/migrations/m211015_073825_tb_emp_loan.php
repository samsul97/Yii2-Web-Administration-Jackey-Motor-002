<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073825_tb_emp_loan extends Migration
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
            '{{%tb_emp_loan}}',
            [
                'id'=> $this->primaryKey(11),
                'id_employee'=> $this->integer(11)->notNull(),
                'nominal'=> $this->bigInteger(20)->notNull(),
                'description'=> $this->string(255)->notNull(),
                'dof'=> $this->date()->notNull()->comment('Tanggal Pengajuan'),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_loan}}');
    }
}
