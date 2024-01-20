<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tb_mechanic".
 *
 * @property int $id
 * @property string $name
 * @property string $telp
 * @property string $address
 * @property string $timestamp
 */
class TbMechanic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mechanic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'telp'], 'required'],
            [['address'], 'string'],
            [['timestamp'], 'safe'],
            [['name', 'telp'], 'string', 'max' => 50],
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
            'telp' => 'Telp',
            'address' => 'Address',
            'timestamp' => 'Tanggal',
        ];
    }
    public static function getCount()
    {
        return static::find()->count();
    }
}
