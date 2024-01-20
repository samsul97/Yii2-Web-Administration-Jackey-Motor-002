<?php

use yii\db\Schema;
use yii\db\Migration;

class m211014_072256_mr_company extends Migration
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
            '{{%mr_company}}',
            [
                'id'=> $this->primaryKey(11),
                'name'=> $this->string(50)->notNull(),
                'desc'=> $this->text()->notNull(),
                'address'=> $this->string(50)->notNull(),
                'telp'=> $this->string(50)->notNull(),
                'email'=> $this->string(50)->notNull(),
                'vision_mision'=> $this->string(50)->notNull(),
                'products'=> $this->text()->notNull(),
                'domain'=> $this->string(50)->notNull(),
                'username'=> $this->string(50)->notNull(),
                'password'=> $this->string(50)->notNull(),
                'url_cpanel'=> $this->string(50)->notNull(),
                'norek_mandiri'=> $this->string(50)->notNull(),
                'norek_bca'=> $this->string(50)->notNull(),
                'norek_cimbniaga'=> $this->string(50)->notNull(),
                'norek_uob'=> $this->string(50)->notNull(),
                'status'=> $this->smallInteger(6)->notNull()->defaultValue(10),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%mr_company}}');
    }
}
