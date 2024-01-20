<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074751_tbemptkpops extends Migration
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
            '{{%tbemptkpops}}',
            [
                'id'=> $this->primaryKey(11),
                'no_receipt'=> $this->string(50)->notNull(),
                'id_tkp_from'=> $this->integer(11)->notNull(),
                'id_tkp_destination'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(11)->notNull(),
                'pic'=> $this->string(50)->notNull(),
                'necessity'=> "enum('Order Barang', 'Lintas Divisi', 'Reject', 'Barang Yang Tidak di Order', 'Transfer Barang', 'Dll') NOT NULL",
                'note'=> $this->text()->notNull(),
                'deadline'=> $this->date()->notNull(),
                'created_at'=> $this->datetime()->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tbemptkpops}}');
    }
}
