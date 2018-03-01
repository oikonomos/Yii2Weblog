<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_page".
 *
 * @property integer $idx
 * @property string $page
 * @property integer $hit
 */
class WebsightLogPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hit'], 'integer'],
            [['page'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'page' => Yii::t('app', 'Page'),
            'hit' => Yii::t('app', 'Hit'),
        ];
    }
}
