<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TbInvoice;

/**
 * TbInvoiceSearch represents the model behind the search form of `backend\models\TbInvoice`.
 */
class TbInvoiceSearch extends TbInvoice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_mechanic', 'id_customer', 'generate_status', 'is_out'], 'integer'],
            [['broughtin', 'received', 'datein', 'dateout', 'timestamp', 'no_invoice'], 'safe'],
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
        $query = TbInvoice::find();

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
            'generate_status' => $this->generate_status,
            'is_out' => $this->is_out,
            'datein' => $this->datein,
            'dateout' => $this->dateout,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'broughtin', $this->broughtin])
        ->andFilterWhere(['like', 'received', $this->received])
        ->andFilterWhere(['like', 'no_invoice', $this->no_invoice]);
            

        return $dataProvider;
    }
}
