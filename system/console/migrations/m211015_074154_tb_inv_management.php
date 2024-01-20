<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074154_tb_inv_management extends Migration
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
            '{{%tb_inv_management}}',
            [
                'id'=> $this->primaryKey(11),
                'in_arrival'=> $this->bigInteger(20)->notNull()->defaultValue(0),
                'in_selling'=> $this->bigInteger(20)->notNull()->defaultValue(0),
                'out_sales'=> $this->bigInteger(20)->notNull()->defaultValue(0),
                'out_non_sales'=> $this->bigInteger(20)->notNull()->defaultValue(0),
                'waste'=> $this->bigInteger(20)->null()->defaultValue(0),
                'spoiled'=> $this->bigInteger(20)->null()->defaultValue(0),
                'remarks'=> $this->text()->null()->defaultValue(null),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_inv_management}}');
    }
}
