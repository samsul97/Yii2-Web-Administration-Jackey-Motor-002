<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072240_mr_cctv extends Migration
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
            '{{%mr_cctv}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'vendor'=> $this->string(50)->notNull(),
                'ip'=> $this->string(50)->notNull(),
                'port'=> $this->integer(11)->notNull(),
                'username'=> $this->string(50)->notNull(),
                'password'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_cctv}}');
    }
}
