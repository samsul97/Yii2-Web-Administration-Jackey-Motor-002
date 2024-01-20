<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073621_tb_assets_return extends Migration
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
            '{{%tb_assets_return}}',
            [
                'id'=> $this->primaryKey(11),
                'id_loan'=> $this->integer(11)->notNull()->comment('Barang Yang di Pinjam'),
                'id_user'=> $this->integer(11)->notNull()->comment('By User'),
                'qty_return'=> $this->integer(11)->notNull(),
                'condition'=> $this->text()->notNull(),
                'dor'=> $this->datetime()->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_assets_return}}');
    }
}
