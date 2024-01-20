<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseStringHelper;

/**
 * This is the model class for table "tb_invoice".
 *
 * @property int $id
 * @property string $name_cust
 * @property string $address_cust
 * @property string $phone_cust
 * @property string $model
 * @property string $variant
 * @property string $prod_year
 * @property string $merk
 * @property string $chasis
 * @property string $received
 * @property string $regdate
 * @property string $datein
 * @property string $dateout
 * @property string $engine
 * @property int $km
 * @property string $timestamp
 */
class TbInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_invoice', 'broughtin', 'received', 'regdate', 'datein', 'dateout', 'km'], 'required'],
            [['datein', 'dateout', 'timestamp'], 'safe'],
            [['km', 'id_mechanic', 'id_customer', 'id_estimation', 'is_invoice', 'is_out'], 'integer'],
            [['no_invoice', 'broughtin', 'received', 'regdate', 'km'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_customer' => 'Pelanggan',
            'id_mechanic' => 'Mechanic',
            'no_invoice' => 'Nomor Invoice',
            'broughtin' => 'Brought in',
            'received' => 'Received',
            'regdate' => 'Regdate',
            'datein' => 'Date in',
            'dateout' => 'Date out',
            'km' => 'Km',
            'is_invoice' => 'Cetak dari',
            'is_out' => 'Status',
            'timestamp' => 'Tgl Invoice',
        ];
    }
    public function getOrderItems()
    {
        if ($this->is_invoice == 1) { // from estimation
            return $this->hasMany(TbService::className(), ['id_tb_estimation' => 'id']);
        } else {
            return $this->hasMany(TbService::className(), ['id_tb_invoice' => 'id']);
        }
    }
    public static function getCount()
    {
        return static::find()->count();
    }
    public function getCustomer()
    {
        return $this->hasOne(TbCustomer::className(), ['id' => 'id_customer']);
    }

    public function customerName()
    {
        $selectCustomer = ArrayHelper::map(TbCustomer::find()->orderBy(['timestamp' => SORT_DESC])->asArray()->all(), 'id',
                            function($model, $defaultValue) { 
                                return $model['name'].'-' .$model['plate'];
                            });

        return $selectCustomer;
    }

    public function getMechanic()
    {
        $selectMechanic = ArrayHelper::map(TbMechanic::find()->asArray()->all(), 'id', function($model, $defaultValue) {
            return $model['name'];
        }
        );

        return $selectMechanic;
    }

    public function generateInvoiceNumber($customerId)
    {
        $code_digit  = 3;
        $code_tgl    = date('Ymd');
        $cek         = TbCustomer::find()->where(['id' => $customerId])->one();
        $code_prefix = $cek->plate;
        $code_model  = TbInvoice::find()->max('id');
        $code_seq    = str_pad($code_model + 1 , $code_digit, '0', STR_PAD_LEFT);
        
        $code_format = 'INV-'. $code_tgl. '-' .$code_prefix. '-' . $code_seq;

        return $code_format;
    }

    public function getEstimation()
    {
        return $this->hasOne(TbEstimation::className(), ['id' => 'id_estimation']);
    }
}
