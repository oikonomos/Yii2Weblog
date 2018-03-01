<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Menu;

/**
 * MenuSearch represents the model behind the search form about `app\models\Menu`.
 */
class MenuSearch extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'owner_id', 'menu_order', 'parent', 'status'], 'integer'],
            [['menu_label', 'menu_link', 'menu_active', 'menu_layout', 'menu_params'], 'safe'],
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
                $query = Menu::find();

                // add conditions that should always apply here

                $dataProvider = new ActiveDataProvider([
                        'query' => $query,
                        'sort' => [
                                'defaultOrder' => [
                                        'menu_order' => SORT_ASC,
                                        'parent' => SORT_ASC,
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
                    'menu_id' => $this->menu_id,
                    'menu_order' => $this->menu_order,
                    'owner_id' => $this->owner_id,
                    'parent' => $this->parent,
                    'status' => $this->status,
                ]);

                $query->andFilterWhere(['like', 'menu_label', $this->menu_label])
                    ->andFilterWhere(['like', 'menu_link', $this->menu_link])
                    ->andFilterWhere(['like', 'menu_active', $this->menu_active])
                    ->andFilterWhere(['like', 'menu_layout', $this->menu_layout])
                    ->andFilterWhere(['like', 'menu_params', $this->menu_params])
                    ->andFilterWhere(['like', 'menu_active', $this->menu_active]);

                return $dataProvider;
        }
}
