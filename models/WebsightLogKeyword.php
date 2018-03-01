<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_keyword".
 *
 * @property integer $idx
 * @property string $keyword
 * @property integer $hit
 */
class WebsightLogKeyword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_keyword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['keyword'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'keyword' => Yii::t('app', 'Keyword'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
