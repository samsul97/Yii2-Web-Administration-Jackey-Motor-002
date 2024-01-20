<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071322_set_be_view extends Migration
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
            '{{%set_be_view}}',
            [
                'id'=> $this->primaryKey(11),
                'header_side_logo'=> $this->string(50)->notNull(),
                'header_side_color'=> $this->char(50)->notNull(),
                'navbar_main_color'=> $this->char(50)->notNull(),
                'navbar_btn_color'=> $this->char(50)->notNull(),
                'sidebar_color'=> $this->char(50)->notNull(),
                'footer_color'=> $this->char(50)->notNull(),
                'footer_content'=> $this->string(50)->notNull(),
                'favicon'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_be_view}}');
    }
}
