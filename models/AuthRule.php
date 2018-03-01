<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthItem[] $authItems
 */
class AuthRule extends \yii\db\ActiveRecord
{
    public $role;
    public $parent;
    public $description;
    public $child;
    public $classname;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_rule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classname'], 'required'],
            [['data', 'parent', 'child', 'description', 'role', 'classname'], 'string'],
            [['updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'role' => Yii::t('app', 'Role'),
            'classname' => Yii::t('app', 'Classname'),
            'parent' => Yii::t('app', 'Parent'),
            'child' => Yii::t('app', 'Child'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::className(), ['rule_name' => 'name']);
    }
    
    /**
     * @return string
     */
    public function displayRuleData()
    {
        $unserializedData = unserialize($this->data);
        $ret = '';
        foreach ($unserializedData as $key => $value) {
            $ret .= $key . " : " . $value . '<br />';
        }

        return $ret;
    }

    /**
     * @param name Rule classname
     * @return mixed object
     */
    public function getRule($name='AuthorRule')
    {
        switch ($name):
            case 'AuthorRule':
                return new \app\rbac\AuthorRule;
        endswitch;
        
        return null;
    }
}
