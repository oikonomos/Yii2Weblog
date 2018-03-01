<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_searchengin".
 *
 * @property integer $idx
 * @property string $searchengin
 * @property integer $hit
 */
class WebsightLogSearchengin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_searchengin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['searchengin'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'searchengin' => Yii::t('app', 'Searchengin'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
