<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071540_set_fe_footer3_help extends Migration
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
            '{{%set_fe_footer3_help}}',
            [
                'id'=> $this->primaryKey(11),
                'id_menu'=> $this->integer(11)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_footer3_help}}');
    }
}
