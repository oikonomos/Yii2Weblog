<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $co_id
 * @property string $post_id
 * @property integer $author_id
 * @property string $writer
 * @property string $email
 * @property string $url
 * @property string $ip
 * @property string $content
 * @property string $parent
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property integer $group_id
 * @property integer $level
 * @property integer $sequence
 *
 * @property Post $post
 * @property Commentmeta[] $commentmetas
 */
class Comment extends \yii\db\ActiveRecord
{
    public $title;
    const STATUS_DELETED = 0;
    const STATUS_PUBLISHED = 10;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'author_id', 'parent', 'status', 'group_id', 'level', 'sequence'], 'integer'],
            [['post_id', 'writer', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['writer'], 'string', 'max' => 100],
            [['email', 'url'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 64],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'po_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'co_id' => Yii::t('app', 'Comment ID'),
            'post_id' => Yii::t('app', 'Post ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'writer' => Yii::t('app', 'Writer'),
            'title' => Yii::t('app', 'Title'),
            'email' => Yii::t('app', 'Email'),
            'url' => Yii::t('app', 'Url'),
            'ip' => Yii::t('app', 'Ip'),
            'content' => Yii::t('app', 'Content'),
            'parent' => Yii::t('app', 'Parent'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'group_id' => Yii::t('app', 'Group ID'),
            'level' => Yii::t('app', 'Level'),
            'sequence' => Yii::t('app', 'Sequence'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['po_id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentmetas()
    {
        return $this->hasMany(Commentmeta::className(), ['comment_id' => 'co_id']);
    }

    /**
     * Check this comment created by user
    * @return boolean
    */
    public function createdBy($user)
    {
       return ($this->author_id == $user) ? true : false;
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
    
    /**
     * Get states
     * @return array
     */
    public function getStates()
    {
        return [
            [
                'key' => self::STATUS_DELETED,
                'value' => "STATUS_DELETED"
            ],
            [
                'key' => self::STATUS_PUBLISHED,
                'value' => "STATUS_PUBLISHED"
            ]
        ];        
    }
}
