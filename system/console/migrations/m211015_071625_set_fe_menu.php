<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071625_set_fe_menu extends Migration
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
            '{{%set_fe_menu}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull()->comment('Nama Menu'),
                'content'=> $this->text()->notNull(),
                'slug'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_menu}}');
    }
}
