<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WebsightLog;

/**
 * WebsightLogSearch represents the model behind the search form about `app\models\WebsightLog`.
 */
class WebsightLogSearch extends WebsightLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idx', 'user_id', 'browser', 'domain', 'referer', 'ip', 'searchengin', 'keyword', 'os', 'page'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = WebsightLog::find();

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
                'user_id' => $this->user_id,
                'browser' => $this->browser,
                'domain' => $this->domain,
                'referer' => $this->referer,
                'ip' => $this->ip,
                'searchengin' => $this->searchengin,
                'keyword' => $this->keyword,
                'os' => $this->os,
                'page' => $this->page,
        ]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
