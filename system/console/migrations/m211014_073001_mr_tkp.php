<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_073001_mr_tkp extends Migration
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
            '{{%mr_tkp}}',
            [
                'id'=> $this->primaryKey(11),
                'id_company'=> $this->integer(11)->notNull(),
                'code_location'=> $this->tinyInteger(4)->notNull(),
                'name'=> $this->string(50)->notNull(),
                'code'=> $this->char(50)->notNull(),
                'alamat'=> $this->text()->notNull(),
                'branch'=> "enum('JAKARTA', 'DEPOK', 'TANGERANG', 'BANDUNG', 'SEMARANG', 'TANGERANG SELATAN', 'PEKAN BARU') NOT NULL",
                'open_hours'=> $this->string(50)->notNull(),
                'close_hours'=> $this->string(50)->notNull(),
                'responbilities'=> $this->string(50)->notNull(),
                'no_hp'=> $this->string(50)->notNull(),
                'telp'=> $this->string(50)->notNull(),
                'ip_viewer'=> $this->string(50)->notNull(),
                'ip_pos1'=> $this->string(50)->notNull(),
                'ip_pos2'=> $this->string(50)->notNull(),
                'ip_pos3'=> $this->string(50)->notNull(),
                'ip_kitchen'=> $this->string(50)->notNull(),
                'ip_bar'=> $this->string(50)->notNull(),
                'ip_public'=> $this->string(50)->notNull(),
                'ip_office'=> $this->string(50)->notNull(),
                'ip_mikrotik'=> $this->string(50)->notNull(),
                'pass_mikrotik'=> $this->string(50)->notNull(),
                'user_mikrotik'=> $this->string(50)->notNull(),
                'id_cctv'=> $this->integer(11)->notNull(),
                'id_wifi'=> $this->integer(11)->notNull(),
                'status'=> $this->smallInteger(6)->notNull()->defaultValue(10),
                'created_at'=> $this->datetime()->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_tkp}}');
    }
}
