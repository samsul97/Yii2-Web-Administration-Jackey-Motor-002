<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074737_tb_pur_supplier extends Migration
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
            '{{%tb_pur_supplier}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull()->comment('Nama Supplier'),
                'desc'=> $this->text()->notNull(),
                'address'=> $this->text()->notNull(),
                'products'=> $this->text()->notNull(),
                'telp'=> $this->string(50)->notNull(),
                'service'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_pur_supplier}}');
    }
}
