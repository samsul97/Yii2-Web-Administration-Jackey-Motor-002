<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073716_tb_emp_calender_image extends Migration
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
            '{{%tb_emp_calender_image}}',
            [
                'id'=> $this->primaryKey(11),
                'id_calender'=> $this->integer(11)->notNull(),
                'image'=> $this->string(50)->notNull(),
                'image_alt'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_calender_image}}');
    }
}
