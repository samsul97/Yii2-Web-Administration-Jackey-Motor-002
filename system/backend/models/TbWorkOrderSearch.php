<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TbWorkOrder;

/**
 * TbWorkOrderSearch represents the model behind the search form of `backend\models\TbWorkOrder`.
 */
class TbWorkOrderSearch extends TbWorkOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_customer', 'id_mechanic', 'generate_status'], 'integer'],
            [['broughtin', 'received', 'datein', 'dateout', 'timestamp'], 'safe'],
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
        $query = TbWorkOrder::find();

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
            'id_customer' => $this->id_customer,
            'id_mechanic' => $this->id_mechanic,
            'datein' => $this->datein,
            'dateout' => $this->dateout,
            // 'is_invoice' => $this->is_invoice,
            'generate_status' => $this->generate_status,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'broughtin', $this->broughtin])
            ->andFilterWhere(['like', 'received', $this->received]);

        return $dataProvider;
    }
}
