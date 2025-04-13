<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    const IS_OUT = 1;
    const IS_NOT_OUT = 0;
    
    const IS_INVOICE = 1;
    const IS_NOT_INVOICE = 0;

    const FROM_WORK_ORDER = 0;
    const FROM_WORK_ORDER_AND_ESTIMATION = 1;

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
            [['no_invoice', 'broughtin', 'received', 'datein', 'dateout'], 'required'],
            [['datein', 'dateout', 'timestamp'], 'safe'],
            [['id_mechanic', 'id_customer', 'id_work_order', 'is_out', 'generate_status'], 'integer'],
            [['no_invoice', 'broughtin', 'received'], 'string', 'max' => 255],
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
            'datein' => 'Date in',
            'dateout' => 'Date out',
            'generate_status' => 'Cetak dari',
            'is_out' => 'Status',
            'timestamp' => 'Tgl Invoice',
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->workOrder) {
                $this->workOrder->delete();
            }

            foreach ($this->serviceItems as $item) {
                $item->delete();
            }

            return true;
        }

        return false;
    }

    public function getServiceItems()
    {
        return $this->hasMany(TbInvoiceService::className(), ['id_tb_invoice' => 'id']);
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

    public function getMechanicName()
    {
        $selectMechanic = ArrayHelper::map(TbMechanic::find()->asArray()->all(), 'id', function($model, $defaultValue) {
            return $model['name'];
        }
        );

        return $selectMechanic;
    }
    
    public function getWorkOrder()
    {
        return $this->hasOne(TbWorkOrder::className(), ['id' => 'id_work_order']);
    }

    public function getMechanic()
    {
        return $this->hasOne(TbMechanic::className(), ['id' => 'id_mechanic']);
    }
}
