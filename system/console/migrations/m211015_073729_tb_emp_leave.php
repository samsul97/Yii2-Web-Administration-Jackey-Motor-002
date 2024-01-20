<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073729_tb_emp_leave extends Migration
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
            '{{%tb_emp_leave}}',
            [
                'id'=> $this->primaryKey(10)->unsigned(),
                'id_employee'=> $this->integer(10)->notNull(),
                'leave_type'=> "enum('Tahunan', 'Khusus') NOT NULL",
                'leave_type_special'=> "enum('Melahirkan', 'Hamil', 'Menikah', 'Alasan Penting') NULL DEFAULT NULL COMMENT 'Pilihan Cuti Khusus'",
                'start_date'=> $this->date()->notNull(),
                'till_date'=> $this->date()->notNull(),
                'reason'=> $this->string(255)->notNull(),
                'dof'=> $this->date()->notNull()->comment('Tanggal Pengajuan'),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_leave}}');
    }
}
