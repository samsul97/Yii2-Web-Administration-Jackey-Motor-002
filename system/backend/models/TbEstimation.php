<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseStringHelper;

/**
 * This is the model class for table "tb_estimation".
 *
 * @property int $id
 * @property int $id_mechanic
 * @property string $name_cust
 * @property string $address_cust
 * @property string $phone_cust
 * @property string $number_plate
 * @property string $no_invoice
 * @property string $model
 * @property string $broughtin
 * @property string $merk
 * @property string $chasis
 * @property string $received
 * @property string $datein
 * @property string $dateout
 * @property string $engine
 * @property string $timestamp
 */
class TbEstimation extends \yii\db\ActiveRecord
{
    const FROM_ESTIMATION = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_estimation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_estimation', 'broughtin', 'received', 'datein', 'dateout'], 'required'],
            [['datein', 'dateout', 'timestamp'], 'safe'],
            [['id_mechanic', 'id_customer', 'is_invoice', 'is_work_order'], 'integer'],
            [['no_estimation', 'broughtin', 'received'], 'string', 'max' => 255],
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
            'id_mechanic' => 'Mekanik',
            'no_estimation' => 'Nomor Estimasi',
            'broughtin' => 'Brought in',
            'received' => 'Received',
            'datein' => 'Date in',
            'dateout' => 'Date out',
            'timestamp' => 'Tgl Estimasi',
        ];
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->serviceItems as $item) {
                $item->delete();
            }

            return true;
        }

        return false;
    }
    
    public function getServiceItems()
    {
        return $this->hasMany(TbEstimationService::className(), ['id_tb_estimation' => 'id']);
    }

    public function getCount()
    {
        return  static::find()->count();
    }

    public function getCustomer()
    {
        return $this->hasOne(TbCustomer::className(), ['id' => 'id_customer']);
    }

    public function getWorkOrder()
    {
        return $this->hasOne(TbWorkOrder::className(), ['id_estimation' => 'id']);
    }

    public function customerName()
    {
        $selectCustomer = ArrayHelper::map(TbCustomer::find()->orderBy(['timestamp' => SORT_DESC])->asArray()->all(), 'id',
                            function($model, $defaultValue) { 
                                return $model['name'].'-' .$model['plate'];
                            });

        return $selectCustomer;
    }

    public function getMechanicName()
    {
        $selectMechanic = ArrayHelper::map(TbMechanic::find()->asArray()->all(), 'id', function($model, $defaultValue) {
            return $model['name'];
        }
        );

        return $selectMechanic;
    }

    public function generateEstimationNumber($customerId)
    {
        $code_digit  = 3;
        $code_tgl    = date('Ymd');
        $cek         = TbCustomer::find()->where(['id' => $customerId])->one();
        $code_prefix = $cek->plate;
        $code_model  = TbEstimation::find()->max('id');
        $code_seq    = str_pad($code_model + 1 , $code_digit, '0', STR_PAD_LEFT);
        
        $code_format = 'EST-' . $code_tgl. '-' .$code_prefix. '-' . $code_seq;

        return $code_format;
    }
}
