<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071511_set_fe_footer2_testimony extends Migration
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
            '{{%set_fe_footer2_testimony}}',
            [
                'id'=> $this->primaryKey(11),
                'photo'=> $this->string(50)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'desc'=> $this->text()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_footer2_testimony}}');
    }
}
