<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072523_mr_in_parent extends Migration
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
            '{{%mr_in_parent}}',
            [
                'id'=> $this->primaryKey(11),
                'code'=> $this->char(50)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'status'=> $this->tinyInteger(4)->notNull()->defaultValue(10),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_in_parent}}');
    }
}
