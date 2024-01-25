<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_work_order".
 *
 * @property int $id
 * @property int $id_customer
 * @property int $id_mechanic
 * @property string $no_estimation
 * @property string $broughtin
 * @property string $received
 * @property string $regdate
 * @property string $datein
 * @property string $dateout
 * @property string $km
 * @property int $is_invoice
 * @property string $timestamp
 */
class TbWorkOrder extends \yii\db\ActiveRecord
{
    const IS_WORK_ORDER = 1;
    const IS_NOT_WORK_ORDER = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_work_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_work_order', 'id_customer', 'id_mechanic', 'broughtin', 'received', 'datein', 'dateout'], 'required'],
            [['id_customer', 'id_mechanic', 'id_estimation', 'generate_status'], 'integer'],
            [['datein', 'dateout', 'timestamp'], 'safe'],
            [['no_work_order', 'broughtin', 'received'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_work_order' => 'No Working Order',
            'id_customer' => 'Pelanggan',
            'id_mechanic' => 'Mekanik',
            'broughtin' => 'Broughtin',
            'received' => 'Received',
            'datein' => 'Datein',
            'dateout' => 'Dateout',
            'generate_status' => 'Dicetak dari',
            'timestamp' => 'Updated at',
        ];
    }

    public function getCustomer()
    {
        return $this->hasOne(TbCustomer::className(), ['id' => 'id_customer']);
    }

    public function getMechanic()
    {
        return $this->hasOne(TbMechanic::className(), ['id' => 'id_mechanic']);
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

    public function getServiceItems()
    {
        return $this->hasMany(TbWorkOrderService::className(), ['id_tb_work_order' => 'id']);
    }
    public function getInvoice()
    {
        return $this->hasOne(TbInvoice::className(), ['id_work_order' => 'id']);
    }

    public function getEstimation()
    {
        return $this->hasOne(TbEstimation::className(), ['id' => 'id_estimation']);
    }
    
    public function generateWorkOrderNumber($customerId)
    {
        $code_digit  = 3;
        $code_tgl    = date('Ymd');
        $cek         = TbCustomer::find()->where(['id' => $customerId])->one();
        $code_prefix = $cek->plate;
        $code_model  = TbWorkOrder::find()->max('id');
        $code_seq    = str_pad($code_model + 1 , $code_digit, '0', STR_PAD_LEFT);
        
        $code_format = 'WO-'. $code_tgl. '-' .$code_prefix. '-' . $code_seq;

        return $code_format;
    }
}
