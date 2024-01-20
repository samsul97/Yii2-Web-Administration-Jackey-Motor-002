<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072642_mr_in_unit extends Migration
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
            '{{%mr_in_unit}}',
            [
                'id'=> $this->primaryKey(11),
                'code'=> $this->char(50)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'status'=> $this->smallInteger(6)->notNull()->defaultValue(10),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_in_unit}}');
    }
}
