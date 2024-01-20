<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074626_tb_mar_customer extends Migration
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
            '{{%tb_mar_customer}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'telp'=> $this->string(50)->notNull(),
                'email'=> $this->string(50)->notNull(),
                'id_tkp'=> $this->integer(11)->notNull(),
                'created_at'=> $this->datetime()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_mar_customer}}');
    }
}
