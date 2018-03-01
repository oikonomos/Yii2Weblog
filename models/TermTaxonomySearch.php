<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TermTaxonomy;

/**
 * TermTaxonomySearch represents the model behind the search form about `app\models\TermTaxonomy`.
 */
class TermTaxonomySearch extends TermTaxonomy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_taxonomy_id', 'term_id', 'parent', 'family_id', 'level', 'sequence', 'count'], 'integer'],
            [['taxonomy', 'name', 'slug', 'color', 'color2', 'font', 'write_level', 'update_level', 'view_level', 'list_level', 'reply_level'], 'safe'],
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
        $query = TermTaxonomy::find();
        
        // join with
        $query->joinWith(['term b'], true, 'LEFT JOIN');

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
            'term_taxonomy_id' => $this->term_taxonomy_id,
            'term_id' => $this->term_id,
            'parent' => $this->parent,
            'family_id' => $this->family_id,
            'level' => $this->level,
            'sequence' => $this->sequence,
            'count' => $this->count,
        ]);

        $query->andFilterWhere(['like', 'taxonomy', $this->taxonomy])
            ->andFilterWhere(['like', 'b.name', $this->name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'color2', $this->color2])
            ->andFilterWhere(['like', 'font', $this->font])
            ->andFilterWhere(['like', 'write_level', $this->write_level])
            ->andFilterWhere(['like', 'update_level', $this->update_level])
            ->andFilterWhere(['like', 'view_level', $this->view_level])
            ->andFilterWhere(['like', 'list_level', $this->list_level])
            ->andFilterWhere(['like', 'reply_level', $this->reply_level]);
        
        $query->orderBy(['family_id'=>SORT_ASC, 'sequence'=>SORT_ASC]);

        return $dataProvider;
    }
        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function searchByCategory($params)
        {
                $query = TermTaxonomy::find();

                // join with
                $query->joinWith(['term b'], true, 'LEFT JOIN');

                // add conditions that should always apply here

                $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                ]);

                $this->load($params);


                // select only posts that belong to category
                $query->andFilterCompare ('term_taxonomy.term_taxonomy_id', 0, '<>');

                if (!$this->validate()) {
                        // uncomment the following line if you do not want to return any records when validation fails
                        // $query->where('0=1');
                        return $dataProvider;
                }

                // grid filtering conditions
                $query->andFilterWhere([
                        'term_taxonomy_id' => $this->term_taxonomy_id,
                        'term_id' => $this->term_id,
                        'parent' => $this->parent,
                        'family_id' => $this->family_id,
                        'level' => $this->level,
                        'sequence' => $this->sequence,
                        'count' => $this->count,
                ]);

                $query->andFilterWhere(['like', 'taxonomy', $this->taxonomy])
                        ->andFilterWhere(['like', 'b.name', $this->name])
                        ->andFilterWhere(['like', 'color', $this->color])
                        ->andFilterWhere(['like', 'color2', $this->color2])
                        ->andFilterWhere(['like', 'font', $this->font])
                        ->andFilterWhere(['like', 'write_level', $this->write_level])
                        ->andFilterWhere(['like', 'update_level', $this->update_level])
                        ->andFilterWhere(['like', 'view_level', $this->view_level])
                        ->andFilterWhere(['like', 'list_level', $this->list_level])
                        ->andFilterWhere(['like', 'reply_level', $this->reply_level]);

                $query->orderBy(['family_id'=>SORT_ASC, 'sequence'=>SORT_ASC]);

                return $dataProvider;
        }
}
