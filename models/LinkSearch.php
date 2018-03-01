<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Link;

/**
 * LinkSearch represents the model behind the search form about `app\models\Link`.
 */
class LinkSearch extends Link
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_id', 'owner_id'], 'integer'],
            [['name', 'owner', 'url', 'link_type', 'target', 'description', 'visible', 'created_at', 'updated_at', 'rel', 'notes'], 'safe'],
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
        $query = Link::find();

        $query->joinWith(['owner']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if ('author' == Yii::$app->user->role)
            $query->andFilterWhere (['owner_id' => Yii::$app->user->id]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'link_id' => $this->link_id,
            'owner_id' => $this->owner_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user.name', $this->owner])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'link_type', $this->link_type])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'visible', $this->visible])
            ->andFilterWhere(['like', 'rel', $this->rel])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
