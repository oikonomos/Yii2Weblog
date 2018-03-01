<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_browser".
 *
 * @property integer $idx
 * @property string $browser
 * @property integer $hit
 */
class WebsightLogBrowser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_browser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['browser'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'browser' => Yii::t('app', 'Browser'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
