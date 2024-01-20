<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073607_tb_assets_repair extends Migration
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
            '{{%tb_assets_repair}}',
            [
                'id'=> $this->primaryKey(11),
                'id_tb_assets'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(11)->notNull(),
                'condition_issue'=> $this->string(50)->notNull(),
                'status'=> "enum('Progress', 'Pending', 'Done') NOT NULL",
                'qty_repair'=> $this->integer(11)->notNull()->defaultValue(0),
                'dor'=> $this->datetime()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_assets_repair}}');
    }
}
