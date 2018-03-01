<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "popup".
 *
 * @property string $popup_id
 * @property string $title
 * @property integer $width
 * @property integer $height
 * @property integer $dim_x
 * @property integer $dim_y
 * @property string $start_date
 * @property string $end_date
 * @property string $content
 * @property string $popup_type
 * @property string $po_option
 * @property string $po_center
 * @property string $pages
 * @property string $created_at
 * @property string $updated_at
 */
class Popup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'popup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['width', 'height', 'dim_x', 'dim_y'], 'integer'],
            [['content', 'pages'], 'string'],
            [['title', 'po_option'], 'string', 'max' => 255],
            [['popup_type'], 'string', 'max' => 10],
            [['po_center'], 'string', 'max' => 3],
            [['start_date', 'end_date', 'created_at', 'updated_at'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'popup_id' => Yii::t('app', 'Popup ID'),
            'title' => Yii::t('app', 'Title'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'dim_x' => Yii::t('app', 'Dim X'),
            'dim_y' => Yii::t('app', 'Dim Y'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'content' => Yii::t('app', 'Content'),
            'popup_type' => Yii::t('app', 'Popup Type'),
            'po_option' => Yii::t('app', 'Po Option'),
            'po_center' => Yii::t('app', 'Po Center'),
            'pages' => Yii::t('app', 'Pages'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /*
     * Before save
     * @param string $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if ( parent::beforeSave($insert) )
        {
            if ( $this->isNewRecord )
            {
                $this->created_at = date("Y-m-d H:i:s");
            }
            else
            {
                $this->updated_at = date("Y-m-d H:i:s");
            }
            return true;
        }
        return false;
    }
}
