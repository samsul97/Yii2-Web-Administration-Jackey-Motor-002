<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tb_service_work_order".
 *
 * @property int $id
 * @property int $id_tb_work_order
 * @property string $name
 * @property int|null $qty
 * @property float|null $price
 * @property float|null $amount
 */
class TbWorkOrderService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_work_order_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['qty', 'id_tb_work_order'], 'integer'],
            [['price', 'amount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tb_work_order' => 'Work Order',
            'name' => 'Name',
            'qty' => 'Qty',
            'price' => 'Price',
            'amount' => 'Amount',
        ];
    }
}
