<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074546_tb_mar_banners extends Migration
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
            '{{%tb_mar_banners}}',
            [
                'id'=> $this->primaryKey(11),
                'id_user'=> $this->integer(11)->notNull(),
                'title'=> $this->string(50)->notNull(),
                'permalinks'=> $this->string(50)->notNull(),
                'image'=> $this->string(50)->notNull(),
                'is_active'=> $this->integer(11)->notNull(),
                'active_date'=> $this->date()->notNull(),
                'created_at'=> $this->date()->notNull(),
                'updated_at'=> $this->date()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_mar_banners}}');
    }
}
