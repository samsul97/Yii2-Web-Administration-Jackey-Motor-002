<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_071302_mr_blog_category extends Migration
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
            '{{%mr_blog_category}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'status'=> $this->tinyInteger(4)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_blog_category}}');
    }
}
