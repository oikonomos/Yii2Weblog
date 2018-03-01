<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "term".
 *
 * @property integer $term_id
 * @property string $name
 * @property string $slug
 * @property integer $term_order
 *
 * @property Termmeta[] $termmetas
 */
class Term extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'term';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'string', 'max' => 200],
            //[['term_id'], 'require', 'on' => 'update'],
            [['name'], 'unique'],
            [['slug'], 'unique'],
            [['term_order'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'term_id' => Yii::t('app', 'Term ID'),
            'name' => Yii::t('app', 'Term Name'),
            'slug' => Yii::t('app', 'Slug'),
            'term_order' => Yii::t('app', 'Term Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTermmetas()
    {
        return $this->hasMany(Termmeta::className(), ['term_id' => 'term_id']);
    }

    /**
     * @inheritdoc
     * @return TermQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TermQuery(get_called_class());
    }
}
