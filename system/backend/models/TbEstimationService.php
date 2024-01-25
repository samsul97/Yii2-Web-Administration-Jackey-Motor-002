<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tb_service_estimation".
 *
 * @property int $id
 * @property string $name
 * @property int|null $qty
 * @property float|null $price
 * @property float|null $amount
 */
class TbEstimationService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_estimation_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['qty', 'id_tb_estimation'], 'integer'],
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
            'name' => 'Name',
            'qty' => 'Qty',
            'price' => 'Price',
            'amount' => 'Amount',
            'id_tb_estimation' => 'Estimasi',
        ];
    }

    public static function getCountOmset()
    {
        $omset = TbEstimationService::find()->sum('amount');
        return $omset;
    }
}
