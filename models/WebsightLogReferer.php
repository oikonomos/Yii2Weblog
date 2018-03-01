<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_referer".
 *
 * @property integer $idx
 * @property string $referer
 * @property integer $hit
 */
class WebsightLogReferer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_referer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['referer'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'referer' => Yii::t('app', 'Referer'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
