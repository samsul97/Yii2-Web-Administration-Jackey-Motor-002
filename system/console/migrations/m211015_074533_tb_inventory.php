<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074533_tb_inventory extends Migration
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
            '{{%tb_inventory}}',
            [
                'id'=> $this->primaryKey(11),
                'sku'=> $this->char(50)->notNull(),
                'desc'=> $this->string(225)->notNull(),
                'id_in_parent'=> $this->char(50)->null()->defaultValue(null),
                'id_in_type'=> $this->integer(11)->notNull(),
                'id_in_unit'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(11)->notNull(),
                'status'=> $this->smallInteger(6)->notNull()->defaultValue(10),
                'code_satuan'=> $this->char(50)->notNull(),
                'code_out'=> $this->char(50)->notNull(),
                'code_in'=> $this->char(50)->notNull(),
                'code_log'=> $this->char(50)->null()->defaultValue(null),
                'code_waste'=> $this->char(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_inventory}}');
    }
}
