<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073943_tb_emp_payroll extends Migration
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
            '{{%tb_emp_payroll}}',
            [
                'id'=> $this->primaryKey(11),
                'id_employee'=> $this->integer(11)->notNull()->comment('Get Cuti dan Absen Karyawan'),
                'month_years'=> $this->date()->notNull(),
                'salary'=> $this->bigInteger(20)->notNull(),
                'created_at'=> $this->datetime()->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_payroll}}');
    }
}
