<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073502_tb_assets extends Migration
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
            '{{%tb_assets}}',
            [
                'id'=> $this->primaryKey(11),
                'sku'=> $this->string(50)->notNull()->comment('Kode Barang (Unique)'),
                'id_user'=> $this->integer(11)->notNull(),
                'id_tkp'=> $this->integer(11)->notNull(),
                'id_in_category'=> $this->integer(11)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'brand'=> $this->string(50)->null()->defaultValue(null),
                'price'=> $this->bigInteger(20)->notNull(),
                'guarantee'=> $this->date()->notNull(),
                'completeness'=> $this->text()->notNull(),
                'dop'=> $this->date()->notNull()->comment('Tanggal Beli'),
                'other_information'=> $this->text()->null()->defaultValue(null)->comment('Keterangan'),
                'image'=> $this->string(50)->null()->defaultValue(null),
                'contractor'=> $this->string(50)->null()->defaultValue(null),
                'floor'=> $this->string(50)->null()->defaultValue(null),
                'power'=> $this->string(50)->null()->defaultValue(null)->comment('Watt'),
                'qty'=> $this->integer(11)->notNull()->defaultValue(0)->comment('Jumlah total awal yang tidak bisa diubah'),
                'qty_current'=> $this->integer(11)->notNull()->defaultValue(0)->comment('Jumlah total yang sudah dikalkulasi dengan barang rusak'),
                'condition_issue'=> $this->text()->notNull(),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_assets}}');
    }
}
