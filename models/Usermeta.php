<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usermeta".
 *
 * @property string $meta_id
 * @property integer $user_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property User $user
 */
class Usermeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usermeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'meta_key'], 'required'],
            [['user_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
            [['user_id', 'meta_key'], 'unique', 'targetAttribute' => ['user_id', 'meta_key'], 'message' => 'The combination of User ID and Meta Key has already been taken.'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'meta_id' => Yii::t('app', 'Meta ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'meta_key' => Yii::t('app', 'Meta Key'),
            'meta_value' => Yii::t('app', 'Meta Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
