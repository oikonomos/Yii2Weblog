<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property string $option_id
 * @property string $name
 * @property string $value
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => Yii::t('app', 'Option ID'),
            'name' => Yii::t('app', 'Option Name'),
            'value' => Yii::t('app', 'Option Value'),
        ];
    }
}
