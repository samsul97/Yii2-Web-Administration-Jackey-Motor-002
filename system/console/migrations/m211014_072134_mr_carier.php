<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072134_mr_carier extends Migration
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
            '{{%mr_carier}}',
            [
                'id'=> $this->primaryKey(11),
                'city_name'=> "enum('JAKARTA', 'TANGERANG', 'TANGERANG SELATAN', 'DEPOK', 'BANDUNG', 'SEMARANG', 'PEKAN BARU') NOT NULL",
                'position'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_carier}}');
    }
}
