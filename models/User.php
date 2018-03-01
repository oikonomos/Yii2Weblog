<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $name
 * @property string $nickname
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $password;
    public $firstname;
    public $lastname;
    public $zipcode;
    public $address;
    public $en_address;
    public $phone;
    public $mobilephone;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'nickname', 'email'], 'required'],
            [
                ['password'],
                'required',
                'on'=>'create'
            ],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'min' => 4, 'max' => 30],
            [['password_hash', 'password_reset_token'], 'string', 'min' => 4, 'max' => 255],
            [
                ['username'], 
                'match',
                'pattern'=>'/^[A-Za-z0-9_]{4,20}$/u',  
                'message'=>Yii::t('app', '{attribute} contains string that is not allowed.'),
            ],
            [['name', 'nickname'], 'string', 'min' => 3, 'max' => 100],
            [
                ['name', 'nickname'], 
                'match',
                'not'=> true,
                'pattern'=>'/[#\&\+\-%@=\/\\\:;,\.\'"\^`~\_|\!\?\*$#<>()\[\]\{\}]/u',
                'message'=>Yii::t('app', '{attribute} contains string that is not allowed.'),
            ],
            [['email'], 'string', 'max' => 255],
            ['email', 'email'],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'min' => 4, 'max' => 30],
            [['password'], 'string', 'min' => 4, 'max' => 30],
            [
                ['password'],
                'match',
                'pattern'=>'/^[A-Za-z0-9_!@#$%^&*()]{4,30}$/u', 
                'message'=>Yii::t('app', 'The format of the password was wrong.'),
            ],
            [['zipcode', 'address', 'en_address', 'phone', 'mobilephone'], 'string'],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'name' => Yii::t('app', 'Name'),
            'nickname' => Yii::t('app', 'Nickname'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Role'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

        /**
         * @inheritdoc
         */
        public static function findIdentityByAccessToken($token, $type = null)
        {
                throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
        }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }    

    /**
     * @inheritdoc
     */
    public function checkSuperAdmin()
    {
        return ($this->username == 'admin') ? 1 : 0;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Link::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasMany(Media::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsermetas()
    {
        return $this->hasMany(Usermeta::className(), ['user_id' => 'id']);
    }
    
    /**
    * @return void
    */
    public function setUsermetas()
    {
        $metas = $this->getUsermetas()->all();
        
        if (is_array($metas)) {
            foreach ($metas as $key => $value) {
                setAttribute($key, $value);
            }
        }
    }
    
    /**
    * @return void
    */
    public function saveUsermetas($metas)
    {
        foreach($metas as $key => $value) {
            $model = Usermeta::find()->where(['user_id'=>$this->id, 'meta_key'=>$key])->one();
            if ($model === null) {
                $model = new Usermeta();
                $model->meta_key = $key;
                $model->user_id = $this->id;
            }
            
            $model->meta_value = $value;
            
            $model->save();
        }
    }
    
    /**
     * Get states
     * @return string
     */
    public function getState()
    {
        return ( $this->status == self::STATUS_DELETED ) ? "STATUS_DELETED" : "STATUS_ACTIVE";        
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
                'key' => self::STATUS_ACTIVE,
                'value' => "STATUS_ACTIVE"
            ]
        ];        
    }
}
