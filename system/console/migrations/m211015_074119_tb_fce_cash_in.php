<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074119_tb_fce_cash_in extends Migration
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
            '{{%tb_fce_cash_in}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_fce_cash_in}}');
    }
}
