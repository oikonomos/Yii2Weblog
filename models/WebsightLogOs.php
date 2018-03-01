<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_os".
 *
 * @property integer $idx
 * @property string $os
 * @property integer $hit
 */
class WebsightLogOs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_os';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['os'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'os' => Yii::t('app', 'Os'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
