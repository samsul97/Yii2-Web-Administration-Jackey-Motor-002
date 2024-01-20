<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_073519_tb_assets_broken extends Migration
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
            '{{%tb_assets_broken}}',
            [
                'id'=> $this->primaryKey(11),
                'id_tb_assets'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(11)->notNull(),
                'qty_broken'=> $this->integer(11)->notNull()->defaultValue(0),
                'is_condition'=> "enum('Good', 'Abnormal', 'Broken') NOT NULL",
                'condition_issue'=> $this->string(255)->notNull(),
                'dob'=> $this->datetime()->notNull()->comment('Date of Broken (Tanggal Kerusakan)'),
                'status'=> "enum('Dijual', 'Dibuang') NULL DEFAULT NULL",
                'is_sale_price'=> $this->bigInteger(20)->null()->defaultValue(null)->comment('Harga Jual'),
                'is_sale_where'=> $this->text()->null()->defaultValue(null)->comment('Ket. Jual Kemana dan Kesiapa'),
                'is_sale_date'=> $this->datetime()->null()->defaultValue(null)->comment('Tanggal Jual'),
                'is_waste_where'=> $this->text()->null()->defaultValue(null)->comment('Ket. Buang Kemana dan Kesiapa'),
                'is_waste_date'=> $this->datetime()->null()->defaultValue(null)->comment('Tanggal Buang'),
                'timestamp'=> $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP"),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_assets_broken}}');
    }
}
