<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074041_tb_emp_visit extends Migration
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
            '{{%tb_emp_visit}}',
            [
                'id'=> $this->primaryKey(11),
                'id_user'=> $this->integer(11)->notNull(),
                'id_tkp'=> $this->integer(11)->notNull(),
                'necessity'=> $this->string(50)->notNull(),
                'vehicle'=> "enum('Kendaraan Kantor', 'Kendaraan Pribadi') NOT NULL",
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_visit}}');
    }
}
