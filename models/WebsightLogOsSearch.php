<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebsightLogOs;

/**
 * WebsightLogOsSearch represents the model behind the search form about `app\models\WebsightLogOs`.
 */
class WebsightLogOsSearch extends WebsightLogOs
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idx', 'hit'], 'integer'],
            [['os'], 'safe'],
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
        $query = WebsightLogOs::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'hit' => $this->hit,
        ]);

        $query->andFilterWhere(['like', 'os', $this->os]);

        return $dataProvider;
    }
}
