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
class TbInvoiceService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_invoice_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['qty', 'id_tb_invoice'], 'integer'],
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
            'name' => 'Service',
            'qty' => 'Qty',
            'price' => 'Harga',
            'amount' => 'Total',
            'timestamp' => 'Timestamp',
        ];
    }
    
    public static function getCountOmset()
    {
        $omset = TbInvoiceService::find()->sum('amount');
        return $omset;
    }

    public function getInvoice()
    {
        return $this->hasOne(TbInvoice::className(), ['id' => 'id_tb_invoice']);
    }
}
