<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property integer $color_id
 * @property string $name
 * @property string $value
 * @property string $description
 * @property string $style
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color_id', 'name', 'value'], 'required'],
            [['color_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 6],
            [['style'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'color_id' => Yii::t('app', 'Color ID'),
            'name' => Yii::t('app', 'Color Name'),
            'value' => Yii::t('app', 'Color Value'),
            'description' => Yii::t('app', 'Description'),
            'style' => Yii::t('app', 'Style'),
        ];
    }
    
    /**
    * @return string
    */
    public function getColorSample()
    {
        return '<span style="display: inline-block; width: 30px; height: 30px; ' . $this->style . ';">&nbsp;</span>';
    }
}
