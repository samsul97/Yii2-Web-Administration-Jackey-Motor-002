<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073551_tb_assets_move extends Migration
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
            '{{%tb_assets_move}}',
            [
                'id'=> $this->primaryKey(11),
                'id_tb_assets'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(11)->notNull(),
                'id_tkp'=> $this->integer(11)->notNull()->comment('TKP TUJUAN'),
                'id_tkp_origin'=> $this->integer(11)->notNull()->comment('TKP ASAL'),
                'qty_move'=> $this->integer(11)->notNull()->defaultValue(0),
                'dom'=> $this->date()->notNull()->comment('Date Of Move (Tanggal Pindah Barang)'),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_assets_move}}');
    }
}
