<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_ip".
 *
 * @property integer $idx
 * @property string $ip
 * @property integer $hit
 */
class WebsightLogIp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_ip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['ip'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'ip' => Yii::t('app', 'Ip'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
