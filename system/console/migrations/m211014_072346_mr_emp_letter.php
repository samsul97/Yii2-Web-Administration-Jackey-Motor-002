<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072346_mr_emp_letter extends Migration
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
            '{{%mr_emp_letter}}',
            [
                'id'=> $this->primaryKey(11),
                'code'=> $this->char(50)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'desc'=> $this->text()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_emp_letter}}');
    }
}
