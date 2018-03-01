<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property string $link_id
 * @property integer $owner_id
 * @property string $name
 * @property string $url
 * @property string $link_type
 * @property string $target
 * @property string $description
 * @property string $visible
 * @property string $created_at
 * @property string $updated_at
 * @property string $rel
 * @property string $notes
 *
 * @property User $owner
 */
class Link extends \yii\db\ActiveRecord
{
        public $owner;
        
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
                return 'link';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                        [['owner_id'], 'required'],
                        [['owner_id'], 'integer'],
                        [['description', 'notes', 'owner'], 'string'],
                        [['created_at', 'updated_at'], 'safe'],
                        [['name', 'url', 'rel'], 'string', 'max' => 255],
                        [['link_type'], 'string', 'max' => 100],
                        [['target'], 'string', 'max' => 30],
                        [['visible'], 'string', 'max' => 20],
                        [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
                return [
                        'link_id' => Yii::t('app', 'Link ID'),
                        'owner_id' => Yii::t('app', 'Owner ID'),
                        'owner' => Yii::t('app', 'Owner'),
                        'name' => Yii::t('app', 'Link Name'),
                        'url' => Yii::t('app', 'Url'),
                        'link_type' => Yii::t('app', 'Link Type'),
                        'target' => Yii::t('app', 'Target'),
                        'description' => Yii::t('app', 'Description'),
                        'visible' => Yii::t('app', 'Visible'),
                        'created_at' => Yii::t('app', 'Created At'),
                        'updated_at' => Yii::t('app', 'Updated At'),
                        'rel' => Yii::t('app', 'Rel'),
                        'notes' => Yii::t('app', 'Notes'),
                ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getOwner()
        {
                return $this->hasOne(User::className(), ['id' => 'owner_id']);
        }

        /**
         * Check this link created by user
        * @return boolean
        */
        public function createdBy($user)
        {
                return ($this->owner_id == $user) ? true : false;
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
