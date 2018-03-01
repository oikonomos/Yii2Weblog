<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AuthRule;

/**
 * AuthRuleSearch represents the model behind the search form about `app\models\AuthRule`.
 */
class AuthRuleSearch extends AuthRule
{
    public $created_date;
    public $updated_date;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'data', 'created_date', 'updated_date'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
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
        $query = AuthRule::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        // date to search
        if ($this->created_date) {
            $date = \DateTime::createFromFormat('Y-m-d', $this->created_date);
            $date->setTime(0,0,0);

            // set lowest date value
            $unixDateStart = $date->getTimeStamp();

            // add 1 day and subtract 1 second
            $date->add(new \DateInterval('P1D'));
            $date->sub(new \DateInterval('PT1S'));

            // set highest date value
            $unixDateEnd = $date->getTimeStamp();

            $query->andFilterWhere(
                ['between', 'created_at', $unixDateStart, $unixDateEnd]);
        }
        
        // date to search
        if ($this->updated_date) {
            $date = \DateTime::createFromFormat('Y-m-d', $this->updated_date);
            $date->setTime(0,0,0);

            // set lowest date value
            $unixDateStart = $date->getTimeStamp();

            // add 1 day and subtract 1 second
            $date->add(new \DateInterval('P1D'));
            $date->sub(new \DateInterval('PT1S'));

            // set highest date value
            $unixDateEnd = $date->getTimeStamp();

            $query->andFilterWhere(
                ['between', 'updated_at', $unixDateStart, $unixDateEnd]);
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }
}
