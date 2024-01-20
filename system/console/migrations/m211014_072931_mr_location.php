<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072931_mr_location extends Migration
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
            '{{%mr_location}}',
            [
                'id'=> $this->primaryKey(11),
                'province_name'=> $this->string(50)->notNull(),
                'city_name'=> $this->string(50)->notNull(),
                'district_name'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_location}}');
    }
}
