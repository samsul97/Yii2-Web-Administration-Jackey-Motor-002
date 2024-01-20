<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074812_tbemptkpposchild extends Migration
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
            '{{%tbemptkpposchild}}',
            [
                'id'=> $this->primaryKey(11),
                'id_emptkpops'=> $this->integer(11)->notNull(),
                'necessity'=> $this->text()->notNull(),
                'image'=> $this->string(50)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tbemptkpposchild}}');
    }
}
