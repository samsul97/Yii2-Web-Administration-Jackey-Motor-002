<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071611_set_fe_header extends Migration
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
            '{{%set_fe_header}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'contact'=> $this->string(50)->notNull(),
                'logo'=> $this->string(50)->notNull(),
                'logo_dark'=> $this->string(50)->notNull(),
                'favicon'=> $this->string(50)->notNull(),
                'navbar_color'=> $this->string(50)->notNull(),
                'btn_color'=> $this->string(50)->notNull(),
                'social_proof_status'=> $this->integer(11)->notNull(),
                'pause_social_proof'=> $this->integer(11)->notNull(),
                'time_social_proof'=> $this->integer(11)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_header}}');
    }
}
