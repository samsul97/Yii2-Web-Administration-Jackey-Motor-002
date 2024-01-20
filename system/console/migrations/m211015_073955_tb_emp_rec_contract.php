<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073955_tb_emp_rec_contract extends Migration
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
            '{{%tb_emp_rec_contract}}',
            [
                'id'=> $this->primaryKey(11),
                'id_employee'=> $this->integer(11)->notNull(),
                'status_contract_origin'=> $this->date()->null()->defaultValue(null),
                'status_contract_destination'=> $this->date()->null()->defaultValue(null),
                'doc'=> $this->datetime()->notNull()->comment('Date Of Contract'),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_emp_rec_contract}}');
    }
}
