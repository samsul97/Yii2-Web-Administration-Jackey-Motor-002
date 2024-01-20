<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072312_mr_division extends Migration
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
            '{{%mr_division}}',
            [
                'id'=> $this->primaryKey(11),
                'department_name'=> $this->string(50)->notNull(),
                'position_name'=> $this->string(50)->notNull(),
                'pass_printer'=> $this->string(50)->notNull(),
                'telp'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_division}}');
    }
}
