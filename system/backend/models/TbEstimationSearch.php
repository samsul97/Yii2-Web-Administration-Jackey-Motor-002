<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TbEstimation;

/**
 * TbEstimationSearch represents the model behind the search form of `backend\models\TbEstimation`.
 */
class TbEstimationSearch extends TbEstimation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_mechanic', 'id_customer'], 'integer'],
            [['broughtin', 'received', 'regdate', 'datein', 'dateout', 'km', 'timestamp', 'no_estimation'], 'safe'],
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
        $query = TbEstimation::find();

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
            'id_mechanic' => $this->id_mechanic,
            'id_customer' => $this->id_customer,
            'datein' => $this->datein,
            'dateout' => $this->dateout,
            'timestamp' => $this->timestamp,
        ]);

        $query
            ->andFilterWhere(['like', 'broughtin', $this->broughtin])
            ->andFilterWhere(['like', 'received', $this->received])
            ->andFilterWhere(['like', 'no_estimation', $this->no_estimation])
            ->andFilterWhere(['like', 'regdate', $this->regdate])
            ->andFilterWhere(['like', 'km', $this->km]);

        return $dataProvider;
    }
}
