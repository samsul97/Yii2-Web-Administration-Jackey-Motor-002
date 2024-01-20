<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073633_tb_emp_administration extends Migration
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
            '{{%tb_emp_administration}}',
            [
                'id'=> $this->primaryKey(11),
                'id_employee'=> $this->integer(11)->notNull(),
                'id_letter'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(11)->notNull()->comment('Important! For value letter'),
                'no_letter'=> $this->string(50)->notNull(),
                'contents'=> $this->text()->null()->defaultValue(null),
                'no_month'=> "enum('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII') NOT NULL",
                'year'=> $this->date(4)->notNull(),
                'created_at'=> $this->date()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
                'pr_old_position'=> $this->string(50)->null()->defaultValue(null),
                'pr_new_position'=> $this->integer(11)->null()->defaultValue(null),
                'pr_old_salary'=> $this->bigInteger(20)->null()->defaultValue(null),
                'pr_new_salary'=> $this->bigInteger(20)->null()->defaultValue(null),
                'act_date'=> $this->date()->null()->defaultValue(null),
                'act_date_expired'=> $this->date()->null()->defaultValue(null),
                'act_old_position'=> $this->string(50)->null()->defaultValue(null),
                'act_new_position'=> $this->integer(11)->null()->defaultValue(null),
                'dm_old_position'=> $this->string(50)->null()->defaultValue(null),
                'dm_new_position'=> $this->integer(11)->null()->defaultValue(null),
                'sm_old_position'=> $this->string(50)->null()->defaultValue(null),
                'sm_new_position'=> $this->string(50)->null()->defaultValue(null),
                'sm_old_boss'=> $this->string(50)->null()->defaultValue(null),
                'sm_new_boss'=> $this->string(50)->null()->defaultValue(null),
                'sm_old_division'=> $this->string(50)->null()->defaultValue(null),
                'sm_new_division'=> $this->string(50)->null()->defaultValue(null),
                'sm_old_company'=> $this->integer(11)->null()->defaultValue(null),
                'sm_new_company'=> $this->integer(11)->null()->defaultValue(null),
                'sm_old_tkp'=> $this->integer(11)->null()->defaultValue(null),
                'sm_new_tkp'=> $this->integer(11)->null()->defaultValue(null),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_administration}}');
    }
}
