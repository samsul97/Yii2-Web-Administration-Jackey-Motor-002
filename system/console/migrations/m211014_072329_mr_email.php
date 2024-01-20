<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072329_mr_email extends Migration
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
            '{{%mr_email}}',
            [
                'id'=> $this->primaryKey(11),
                'id_company'=> $this->integer(11)->notNull(),
                'email'=> $this->string(50)->notNull(),
                'pass'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_email}}');
    }
}
