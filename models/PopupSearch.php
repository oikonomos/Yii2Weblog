<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Popup;

/**
 * PopupSearch represents the model behind the search form about `app\models\Popup`.
 */
class PopupSearch extends Popup
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['popup_id', 'width', 'height', 'dim_x', 'dim_y'], 'integer'],
            [['title', 'start_date', 'end_date', 'content', 'popup_type', 'po_option', 'po_center', 'pages', 'created_at', 'updated_at'], 'safe'],
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
        $query = Popup::find();

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
            'popup_id' => $this->popup_id,
            'width' => $this->width,
            'height' => $this->height,
            'dim_x' => $this->dim_x,
            'dim_y' => $this->dim_y,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'start_date', $this->start_date])
            ->andFilterWhere(['like', 'end_date', $this->end_date])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'popup_type', $this->popup_type])
            ->andFilterWhere(['like', 'po_option', $this->po_option])
            ->andFilterWhere(['like', 'po_center', $this->po_center])
            ->andFilterWhere(['like', 'pages', $this->pages])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
