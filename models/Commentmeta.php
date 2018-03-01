<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "commentmeta".
 *
 * @property string $meta_id
 * @property string $comment_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Comment $comment
 */
class Commentmeta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commentmeta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'meta_key', 'meta_value'], 'required'],
            [['comment_id'], 'integer'],
            [['meta_value'], 'string'],
            [['meta_key'], 'string', 'max' => 255],
            [['comment_id', 'meta_key'], 'unique', 'targetAttribute' => ['comment_id', 'meta_key'], 'message' => 'The combination of Comment ID and Meta Key has already been taken.'],
            [['comment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comment::className(), 'targetAttribute' => ['comment_id' => 'co_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'meta_id' => Yii::t('app', 'Meta ID'),
            'comment_id' => Yii::t('app', 'Comment ID'),
            'meta_key' => Yii::t('app', 'Meta Key'),
            'meta_value' => Yii::t('app', 'Meta Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComment()
    {
        return $this->hasOne(Comment::className(), ['co_id' => 'comment_id']);
    }
}
