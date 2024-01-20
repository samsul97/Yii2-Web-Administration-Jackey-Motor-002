<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074844_tbinvpoin extends Migration
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
            '{{%tbinvpoin}}',
            [
                'id'=> $this->primaryKey(11),
                'id_inv_po_child'=> $this->integer(11)->notNull()->defaultValue(0),
                'id_in_unit'=> $this->integer(11)->notNull(),
                'id_inv'=> $this->integer(11)->notNull(),
                'id_pur_supplier'=> $this->integer(11)->notNull(),
                'qty'=> $this->integer(11)->notNull()->defaultValue(0),
                'doe'=> $this->date()->notNull()->comment('Tanggal Masuk'),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tbinvpoin}}');
    }
}
