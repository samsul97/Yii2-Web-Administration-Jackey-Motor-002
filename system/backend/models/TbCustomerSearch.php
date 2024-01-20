<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TbCustomer;

/**
 * TbCustomerSearch represents the model behind the search form of `backend\models\TbCustomer`.
 */
class TbCustomerSearch extends TbCustomer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [
                ['name',
                'phone', 
                'address',
                'chasis',
                'plate',
                'engine',
                'model',
                'merk', 
                'timestamp'
            ], 
            'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TbCustomer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['timestamp' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'plate', $this->plate])
            ->andFilterWhere(['like', 'engine', $this->engine])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'merk', $this->merk])
            ->andFilterWhere(['like', 'chasis', $this->chasis]);

        return $dataProvider;
    }
}
