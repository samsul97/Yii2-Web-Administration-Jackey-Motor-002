<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072406_mr_in_category extends Migration
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
            '{{%mr_in_category}}',
            [
                'id'=> $this->primaryKey(11),
                'code'=> $this->char(50)->notNull(),
                'name'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_in_category}}');
    }
}
