<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_073022_mr_wifi extends Migration
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
            '{{%mr_wifi}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'url'=> $this->string(50)->notNull(),
                'vendor'=> $this->string(50)->notNull(),
                'ssid'=> $this->string(50)->notNull(),
                'username_modem'=> $this->string(50)->notNull(),
                'pasword_modem'=> $this->string(50)->notNull(),
                'username_login'=> $this->string(50)->notNull(),
                'password_login'=> $this->string(50)->notNull(),
                'speed'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_wifi}}');
    }
}
