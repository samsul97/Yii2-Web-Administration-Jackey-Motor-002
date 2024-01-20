<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073532_tb_assets_loan extends Migration
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
            '{{%tb_assets_loan}}',
            [
                'id'=> $this->primaryKey(11),
                'id_assets'=> $this->integer(11)->notNull()->comment('Barang Yang Di Pinjem'),
                'id_employee'=> $this->integer(11)->notNull()->comment('Nama Karyawan Yang Minjem'),
                'id_user'=> $this->integer(11)->notNull()->comment('By User'),
                'qty_loan'=> $this->integer(11)->notNull(),
                'note'=> $this->string(50)->notNull(),
                'dol'=> $this->datetime()->notNull()->comment('Tanggal Peminjaman'),
                'dor'=> $this->datetime()->notNull()->comment('Tanggal Pengembalian'),
                'status'=> $this->tinyInteger(4)->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_assets_loan}}');
    }
}
