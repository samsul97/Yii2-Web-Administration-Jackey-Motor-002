<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_071441_set_fe_footer2_section extends Migration
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
            '{{%set_fe_footer2_section}}',
            [
                'id'=> $this->primaryKey(11),
                'group_logo'=> $this->string(50)->null()->defaultValue(null),
                'section_color'=> $this->string(50)->notNull()->comment('Testimoni'),
                'updated_at'=> $this->date()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%set_fe_footer2_section}}');
    }
}
