<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `app\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['co_id', 'post_id', 'author_id', 'parent', 'status', 'group_id', 'level', 'sequence'], 'integer'],
            [['writer', 'email', 'title', 'url', 'ip', 'content', 'created_at', 'updated_at'], 'safe'],
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
        $query = Comment::find();

        // add conditions that should always apply here

        $query->joinWith(['post']);

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
            'co_id' => $this->co_id,
            'post_id' => $this->post_id,
            'author_id' => $this->author_id,
            'parent' => $this->parent,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'group_id' => $this->group_id,
            'level' => $this->level,
            'sequence' => $this->sequence,
        ]);

        $query->andFilterWhere(['like', 'writer', $this->writer])
            ->andFilterWhere(['like', 'post.title', $this->title])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
