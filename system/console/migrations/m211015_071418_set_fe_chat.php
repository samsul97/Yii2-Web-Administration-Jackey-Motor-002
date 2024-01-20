<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071418_set_fe_chat extends Migration
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
            '{{%set_fe_chat}}',
            [
                'id'=> $this->primaryKey(11),
                'chat_help_status'=> $this->integer(11)->notNull(),
                'message'=> $this->text()->notNull(),
                'color'=> $this->string(50)->notNull(),
                'direct_wa'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_chat}}');
    }
}
