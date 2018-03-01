<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Media;

/**
 * MediaSearch represents the model behind the search form about `app\models\Media`.
 */
class MediaSearch extends Media
{
        
        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                        [['media_id', 'owner_id', 'file_size', 'thumb_width', 'thumb_height'], 'integer'],
                        [['display_filename', 'filename', 'name', 'caption', 'file_type', 'file_mime_type', 'file_url', 'file_path', 'thumb_url', 'thumb_path', 'created_at', 'updated_at', 'description'], 'safe'],
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
                $query = Media::find();

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
                        'media_id' => $this->media_id,
                        'owner_id' => $this->owner_id,
                        'file_size' => $this->file_size,
                        'thumb_width' => $this->thumb_width,
                        'thumb_height' => $this->thumb_height,
                        'created_at' => $this->created_at,
                        'updated_at' => $this->updated_at,
                ]);

                $query->andFilterWhere(['like', 'display_filename', $this->display_filename])
                        ->andFilterWhere(['like', 'filename', $this->filename])
                        ->andFilterWhere(['like', 'user.name', $this->name])
                        ->andFilterWhere(['like', 'caption', $this->caption])
                        ->andFilterWhere(['like', 'file_type', $this->file_type])
                        ->andFilterWhere(['like', 'file_mime_type', $this->file_mime_type])
                        ->andFilterWhere(['like', 'file_url', $this->file_url])
                        ->andFilterWhere(['like', 'file_path', $this->file_path])
                        ->andFilterWhere(['like', 'thumb_url', $this->thumb_url])
                        ->andFilterWhere(['like', 'thumb_path', $this->thumb_path])
                        ->andFilterWhere(['like', 'description', $this->description]);

                return $dataProvider;
        }
}
