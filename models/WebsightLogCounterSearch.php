<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebsightLogCounter;

/**
 * WebsightLogCounterSearch represents the model behind the search form about `app\models\WebsightLogCounter`.
 */
class WebsightLogCounterSearch extends WebsightLogCounter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idx', 'h0', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'h8', 'h9', 'h10', 'h11', 'h12', 'h13', 'h14', 'h15', 'h16', 'h17', 'h18', 'h19', 'h20', 'h21', 'h22', 'h23', 'hit'], 'integer'],
            [['yyyy', 'mm', 'dd', 'week'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
            $query = WebsightLogCounter::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                            'defaultOrder' => [
                                    'yyyy' => SORT_DESC,
                                    'mm' => SORT_DESC,
                                    'dd' => SORT_DESC,
                            ]
                    ]
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'idx' => $this->idx,
                'h0' => $this->h0,
                'h1' => $this->h1,
                'h2' => $this->h2,
                'h3' => $this->h3,
                'h4' => $this->h4,
                'h5' => $this->h5,
                'h6' => $this->h6,
                'h7' => $this->h7,
                'h8' => $this->h8,
                'h9' => $this->h9,
                'h10' => $this->h10,
                'h11' => $this->h11,
                'h12' => $this->h12,
                'h13' => $this->h13,
                'h14' => $this->h14,
                'h15' => $this->h15,
                'h16' => $this->h16,
                'h17' => $this->h17,
                'h18' => $this->h18,
                'h19' => $this->h19,
                'h20' => $this->h20,
                'h21' => $this->h21,
                'h22' => $this->h22,
                'h23' => $this->h23,
                'hit' => $this->hit,
            ]);

            $query->andFilterWhere(['like', 'yyyy', $this->yyyy])
                ->andFilterWhere(['like', 'mm', $this->mm])
                ->andFilterWhere(['like', 'dd', $this->dd])
                ->andFilterWhere(['like', 'week', $this->week]);

            return $dataProvider;
        }
        
        
        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function monthlySearch($params)
        {
            $query = WebsightLogCounter::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                            'defaultOrder' => [
                                    'yyyy' => SORT_DESC,
                                    'mm' => SORT_DESC,
                                    'dd' => SORT_DESC,
                            ]
                    ],
                    'pagination' => [
                        'pageSize' => 31,
                    ],
            ]);

            $this->load($params);

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'idx' => $this->idx,
                'h0' => $this->h0,
                'h1' => $this->h1,
                'h2' => $this->h2,
                'h3' => $this->h3,
                'h4' => $this->h4,
                'h5' => $this->h5,
                'h6' => $this->h6,
                'h7' => $this->h7,
                'h8' => $this->h8,
                'h9' => $this->h9,
                'h10' => $this->h10,
                'h11' => $this->h11,
                'h12' => $this->h12,
                'h13' => $this->h13,
                'h14' => $this->h14,
                'h15' => $this->h15,
                'h16' => $this->h16,
                'h17' => $this->h17,
                'h18' => $this->h18,
                'h19' => $this->h19,
                'h20' => $this->h20,
                'h21' => $this->h21,
                'h22' => $this->h22,
                'h23' => $this->h23,
                'hit' => $this->hit,
            ]);

            $query->andFilterWhere(['like', 'yyyy', $this->yyyy])
                ->andFilterWhere(['like', 'mm', $this->mm])
                ->andFilterWhere(['like', 'dd', $this->dd])
                ->andFilterWhere(['like', 'week', $this->week]);

            return $dataProvider;
        }
}
