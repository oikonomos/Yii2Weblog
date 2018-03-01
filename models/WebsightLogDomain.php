<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_domain".
 *
 * @property integer $idx
 * @property string $domain
 * @property integer $hit
 */
class WebsightLogDomain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_domain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['domain'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'domain' => Yii::t('app', 'Domain'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
