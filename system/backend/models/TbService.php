<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tb_service".
 *
 * @property int $id
 * @property int $id_tb_invoice
 * @property string $name
 * @property int $qty
 * @property float $price
 * @property float $amount
 * @property string $timestamp
 */
class TbService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['qty', 'id_tb_invoice', 'id_tb_estimation'], 'integer'],
            [['price'], 'number'],
            [['amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tb_invoice' => 'Invoice',
            'id_tb_estimation' => 'Invoice',
            'id_tb_working_order' => 'Invoice',
            'name' => 'Service',
            'qty' => 'Qty',
            'price' => 'Harga',
            'amount' => 'Total',
            'timestamp' => 'Timestamp',
        ];
    }
    public static function getCountOmset()
    {
        $omset = TbService::find()->sum('amount');
        return $omset;
    }

    public function getEstimation()
    {
        return $this->hasOne(TbEstimation::className(), ['id' => 'id_tb_estimation']);
    }

    public function getInvoice()
    {
        return $this->hasOne(TbInvoice::className(), ['id' => 'id_tb_invoice']);
    }
}
