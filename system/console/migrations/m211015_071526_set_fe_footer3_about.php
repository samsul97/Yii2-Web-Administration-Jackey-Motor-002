<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071526_set_fe_footer3_about extends Migration
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
            '{{%set_fe_footer3_about}}',
            [
                'id'=> $this->primaryKey(11),
                'desc'=> $this->text()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_footer3_about}}');
    }
}
