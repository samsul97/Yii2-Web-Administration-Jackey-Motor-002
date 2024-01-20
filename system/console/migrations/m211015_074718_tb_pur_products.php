<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074718_tb_pur_products extends Migration
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
            '{{%tb_pur_products}}',
            [
                'id'=> $this->primaryKey(11),
                'id_company'=> $this->integer(11)->notNull(),
                'id_in_type'=> $this->integer(11)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'image'=> $this->string(50)->notNull(),
                'price'=> $this->bigInteger(20)->notNull(),
                'created_at'=> $this->datetime()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_pur_products}}');
    }
}
