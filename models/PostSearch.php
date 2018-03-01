<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Post;
use app\models\TermTaxonomy;

/**
 * PostSearch represents the model behind the search form about `app\models\Post`.
 */
class PostSearch extends Post
{
        public $tt_id;

        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                        [['po_id', 'author_id', 'parent', 'term_taxonomy_id', 'status', 'group_id', 'level', 'sequence', 'hit_count', 'comment_count'], 'integer'],
                        [['password', 'writer', 'title', 'content', 'excerpt', 'email', 'homepage', 'termname', 'created_at', 'updated_at', 'tags', 'post_type', 'comment_status'], 'safe'],
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
            $query = Post::find();

            $query->joinWith(['author', 'term'])->viaTable(TermTaxonomy::tableName(), ['term_taxonomy_id'=>'term_taxonomy_id']);

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                            'defaultOrder' => [
                                    'group_id' => SORT_DESC,
                                    'sequence' => SORT_ASC,
                            ]
                    ]
            ]);

            $this->load($params);

            if ('author' == Yii::$app->user->role)
                $query->andFilterWhere (['author_id' => Yii::$app->user->id]);
            
            // select only posts that belong to category
            $query->andFilterCompare ('post.term_taxonomy_id', 0, '<>');

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'po_id' => $this->po_id,
                'author_id' => $this->author_id,
                'parent' => $this->parent,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'term_taxonomy_id' => $this->term_taxonomy_id,
                'status' => $this->status,
                'group_id' => $this->group_id,
                'level' => $this->level,
                'sequence' => $this->sequence,
                'hit_count' => $this->hit_count,
                'comment_count' => $this->comment_count,
            ]);

            if ($this->tt_id)
                $query->andFilterWhere (['post.term_taxonomy_id' => $this->tt_id]);

            $query->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'writer', $this->writer])
                ->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'content', $this->content])
                ->andFilterWhere(['like', 'excerpt', $this->excerpt])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'homepage', $this->homepage])
                ->andFilterWhere(['like', 'term.name', $this->termname])
                ->andFilterWhere(['like', 'tags', $this->tags])
                ->andFilterWhere(['like', 'post_type', $this->post_type])
                ->andFilterWhere(['like', 'comment_status', $this->comment_status]);

            return $dataProvider;
        }
        
        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function searchByTaxonomy($params)
        {
            $query = Post::find();

            $query->joinWith(['author', 'term'])->viaTable(TermTaxonomy::tableName(), ['term_taxonomy_id'=>'term_taxonomy_id']);

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                            'defaultOrder' => [
                                    'group_id' => SORT_DESC,
                                    'sequence' => SORT_ASC,
                            ]
                    ]
            ]);

            $this->load($params);

            if ('author' == Yii::$app->user->role)
                $query->andFilterWhere (['author_id' => Yii::$app->user->id]);
            
            // select only posts that belong to category
            $query->andFilterCompare ('post.term_taxonomy_id', 0, '<>');

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                'po_id' => $this->po_id,
                'author_id' => $this->author_id,
                'parent' => $this->parent,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                //'post.term_taxonomy_id' => $this->tt_id,
                'status' => $this->status,
                'group_id' => $this->group_id,
                'level' => $this->level,
                'sequence' => $this->sequence,
                'hit_count' => $this->hit_count,
                'comment_count' => $this->comment_count,
            ]);

            if ($this->tt_id) {
                    $condition = '';
                    foreach ( TermTaxonomy::getTermTaxonomyDescendants( $this->tt_id ) as $value ) {
                            $condition .= " post.term_taxonomy_id = " . $value . ' or'; 
                    }
                    $condition = trim( $condition, ' or' );
                    $query->andWhere ( $condition );                    
            }            

            $query->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'writer', $this->writer])
                ->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'content', $this->content])
                ->andFilterWhere(['like', 'excerpt', $this->excerpt])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'homepage', $this->homepage])
                ->andFilterWhere(['like', 'tags', $this->tags])
                ->andFilterWhere(['like', 'post_type', $this->post_type])
                ->andFilterWhere(['like', 'comment_status', $this->comment_status]);

            return $dataProvider;
        }
    
        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function gsearch($params)
        {
            $query = Post::find();

            $query->joinWith(['author', 'term'])->viaTable(TermTaxonomy::tableName(), ['term_taxonomy_id'=>'term_taxonomy_id']);

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                            'defaultOrder' => [
                                    'group_id' => SORT_DESC,
                                    'sequence' => SORT_ASC,
                            ]
                    ]
            ]);

            $this->load($params);

            /*if ('author' == Yii::$app->user->role)
                $query->andFilterWhere (['author_id' => Yii::$app->user->id]);*/

            if (!$this->validate()) {
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            $query->orFilterWhere(['like', 'title', $this->title])
                ->orFilterWhere(['like', 'content', $this->content])
                ->orFilterWhere(['like', 'tags', $this->tags]);

            return $dataProvider;
        }
/**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function pgsearch($params)
        {
                $query = Post::find();

                $query->joinWith(['author', 'term'])->viaTable(TermTaxonomy::tableName(), ['term_taxonomy_id'=>'term_taxonomy_id']);

                // add conditions that should always apply here

                $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                                'defaultOrder' => [
                                        'group_id' => SORT_DESC,
                                        'sequence' => SORT_ASC,
                                ]
                        ]
                ]);

                $this->load($params);

                if ('author' == Yii::$app->user->role)
                    $query->andFilterWhere (['author_id' => Yii::$app->user->id]);

                if (!$this->validate()) {
                    // uncomment the following line if you do not want to return any records when validation fails
                    // $query->where('0=1');
                    return $dataProvider;
                }

                // grid filtering conditions
                $query->andFilterWhere([
                    'po_id' => $this->po_id,
                    'author_id' => $this->author_id,
                    'parent' => $this->parent,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                    'post.term_taxonomy_id' => 0,
                    'status' => $this->status,
                    'group_id' => $this->group_id,
                    'level' => $this->level,
                    'sequence' => $this->sequence,
                    'hit_count' => $this->hit_count,
                    'comment_count' => $this->comment_count,
                ]);

                if ($this->tt_id)
                    $query->andFilterWhere (['post.term_taxonomy_id' => $this->tt_id]);

                $query->andFilterWhere(['like', 'password', $this->password])
                    ->andFilterWhere(['like', 'writer', $this->writer])
                    ->andFilterWhere(['like', 'title', $this->title])
                    ->andFilterWhere(['like', 'content', $this->content])
                    ->andFilterWhere(['like', 'excerpt', $this->excerpt])
                    ->andFilterWhere(['like', 'email', $this->email])
                    ->andFilterWhere(['like', 'homepage', $this->homepage])
                    ->andFilterWhere(['like', 'tags', $this->tags])
                    ->andFilterWhere(['like', 'post_type', $this->post_type])
                    ->andFilterWhere(['like', 'comment_status', $this->comment_status]);

                return $dataProvider;
        }
}
