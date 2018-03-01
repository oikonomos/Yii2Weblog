<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "postmeta".
 *
 * @property string $meta_id
 * @property string $post_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Post $post
 */
class Postmeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'postmeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'meta_key', 'meta_value'], 'required'],
            [['post_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
            [['post_id', 'meta_key'], 'unique', 'targetAttribute' => ['post_id', 'meta_key'], 'message' => 'The combination of Post ID and Meta Key has already been taken.'],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'po_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'meta_id' => Yii::t('app', 'Meta ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'meta_key' => Yii::t('app', 'Meta Key'),
            'meta_value' => Yii::t('app', 'Meta Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['po_id' => 'post_id']);
    }
}
