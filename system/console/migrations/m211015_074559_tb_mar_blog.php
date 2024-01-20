<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074559_tb_mar_blog extends Migration
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
            '{{%tb_mar_blog}}',
            [
                'id'=> $this->primaryKey(11),
                'id_user'=> $this->integer(11)->notNull(),
                'id_blog_category'=> $this->integer(11)->notNull(),
                'title'=> $this->string(50)->notNull(),
                'contents'=> $this->text()->notNull(),
                'created_at'=> $this->date()->notNull(),
                'image'=> $this->string(50)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_mar_blog}}');
    }
}
