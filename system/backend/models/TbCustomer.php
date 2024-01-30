<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tb_customer".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $timestamp
 */
class TbCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'address', 'chasis', 'plate', 'engine', 'model', 'merk'], 'required'],
            [['address'], 'string'],
            [['regdate', 'timestamp'], 'safe'],
            [['plate'], 'unique'],
            [['name', 'phone', 'chasis', 'plate', 'engine', 'model', 'merk', 'km'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nama Pelanggan',
            'phone' => 'No Telp',
            'address' => 'Alamat Lengkap',
            'chasis' => 'Chasis',
            'plate' => 'Plat Nomor',
            'engine' => 'Nomor Mesin',
            'model' => 'Model',
            'merk' => 'Merk',
            'regdate' => 'Regdate',
            'km' => 'Km',
            'timestamp' => 'Tanggal Daftar',
        ];
    }
    public static function getCount()
    {
        return  static::find()->count();
    }

    public function getEstimation()
    {
        return $this->hasMany(TbEstimation::class, ['id_customer' => 'id']);
    }

    public function getWorkOrder()
    {
        return $this->hasMany(TbWorkOrder::class, ['id_customer' => 'id']);
    }
    
    public function getInvoice()
    {
        return $this->hasMany(TbInvoice::class, ['id_customer' => 'id']);
    }
}
