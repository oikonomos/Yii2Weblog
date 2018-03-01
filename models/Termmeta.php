<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "termmeta".
 *
 * @property integer $meta_id
 * @property integer $term_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Term $term
 */
class Termmeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termmeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['term_id'], 'required'],
            [['term_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
            [['term_id', 'meta_key'], 'unique', 'targetAttribute' => ['term_id', 'meta_key'], 'message' => 'The combination of Term ID and Meta Key has already been taken.'],
            [['term_id'], 'exist', 'skipOnError' => true, 'targetClass' => Term::className(), 'targetAttribute' => ['term_id' => 'term_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'meta_id' => Yii::t('app', 'Meta ID'),
            'term_id' => Yii::t('app', 'Term ID'),
            'meta_key' => Yii::t('app', 'Meta Key'),
            'meta_value' => Yii::t('app', 'Meta Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(Term::className(), ['term_id' => 'term_id']);
    }
}
