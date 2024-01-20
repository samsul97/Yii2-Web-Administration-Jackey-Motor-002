<?php

use yii\db\Schema;
use yii\db\Migration;

class m211015_074102_tb_employee extends Migration
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
            '{{%tb_employee}}',
            [
                'id'=> $this->primaryKey(11),
                'id_company'=> $this->integer(11)->notNull(),
                'id_tkp'=> $this->integer(11)->notNull()->comment('List TKP'),
                'nie'=> $this->string(50)->notNull()->comment('Nomer Induk Karyawan'),
                'nie_old'=> $this->string(50)->null()->defaultValue(null)->comment('Nomer Induk Karyawan Lama'),
                'nik'=> $this->string(50)->notNull()->comment('Nomer Induk Kependudukan'),
                'npwp'=> $this->string(50)->null()->defaultValue(null),
                'name'=> $this->string(50)->notNull(),
                'status'=> "enum('Permanent', 'Contract', 'Probation', 'Resign', 'Blacklist') NOT NULL",
                'date_join'=> $this->date()->notNull(),
                'date_resign'=> $this->date()->null()->defaultValue(null),
                'department'=> $this->string(50)->notNull(),
                'position'=> $this->string(50)->notNull(),
                'pob'=> $this->string(50)->notNull(),
                'dob'=> $this->date()->notNull(),
                'gender'=> "enum('LAKI', 'PEREMPUAN') NOT NULL",
                'married_status'=> "enum('KAWIN', 'BELUM KAWIN', 'KAWIN ANAK SATU', 'KAWIN ANAK DUA', 'KAWIN ANAK TIGA') NOT NULL",
                'national'=> "enum('WNI', 'WNA') NOT NULL",
                'education'=> "enum('SMA/SMK', 'D1', 'D3', 'S1', 'S2', 'S3') NOT NULL",
                'address'=> $this->text()->notNull(),
                'province'=> $this->string(50)->notNull(),
                'city'=> $this->string(50)->notNull(),
                'district'=> $this->string(50)->notNull(),
                'postcode'=> $this->char(5)->null()->defaultValue(null),
                'handphone'=> $this->string(50)->notNull(),
                'email'=> $this->string(50)->notNull(),
                'image'=> $this->string(50)->null()->defaultValue(null),
                'salary'=> $this->bigInteger(20)->null()->defaultValue(null),
                'facilities'=> $this->string(255)->notNull(),
                'fac_tj_nominal'=> $this->string(50)->null()->defaultValue(null)->comment('(Tunjangan Jabatan, Tunjangan Komunikasi, Tunjangan BPJS Kesehatan)'),
                'fac_tk_nominal'=> $this->string(50)->null()->defaultValue(null),
                'fac_tbk_nominal'=> $this->string(50)->null()->defaultValue(null),
                'account_number'=> $this->string(50)->notNull()->comment('Nomor Rekening Karyawan'),
                'other_information'=> $this->text()->null()->defaultValue(null),
                'religion'=> "enum('Islam', 'Kristen', 'Hindu', 'Budha', 'Konghucu', 'Katolik', 'Lain-lain') NOT NULL",
                'telp'=> $this->string(50)->null()->defaultValue(null)->comment('Telp Rumah'),
                'sor'=> "enum('Rumah Orang Tua', 'Rumah Sendiri', 'Kos', 'Kontrak') NOT NULL COMMENT 'Status Tempat Tinggal (Status Of Residence)'",
                'status_probation'=> $this->date()->null()->defaultValue(null),
                'status_contract'=> $this->date()->null()->defaultValue(null)->comment('Status Kontrak Karyawan'),
                'status_resign_reason'=> $this->string(50)->null()->defaultValue(null)->comment('Alasan Resign'),
                'id_bank'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tb_employee}}');
    }
}
