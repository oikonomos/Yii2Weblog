<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $password;
    public $passwordcf;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username', 'name', 'password', 'email'], 'required'],
            [
                'username', 
                'match',
                'pattern'=>'/^[A-Za-z0-9_]{4,20}$/u',  
                'message'=>'{attribute}에 허용되지 않은 문자열이 포함되어 있습니다.',
            ],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => '사용중인 아이디입니다.'],
            ['username', 'string', 'min' => 4, 'max' => 30],
            [['name'], 'string', 'min' => 3, 'max' => 100],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => '사용중인 이메일입니다.'],

            ['password', 'required'],
            //['passwordcf', 'required'],
            ['password', 'string', 'min' => 6, 'max' => 30],
            /*[
                ['password', 'passwordcf'],
                'match',
                'pattern'=>'/^[A-Za-z0-9_!@#$%^&*()]{4,30}$/u', 
                'message'=>'비밀번호 형식이 잘못되었습니다.',
            ],
            ['passwordcf', 'compare', 'compareAttribute' => 'password', 'message' => \Yii::t('app', '{attribute} must be equal to "{compareAttribute}".')],*/
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->name = $this->name;
            $user->nickname = $this->name;
            $user->email = $this->email;
            $user->created_at = time();
            $user->setPassword($this->password);
            $user->role = 'author';
            $user->generateAuthKey();
            if ($user->save()) {
                // the following three lines were added:
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('author');                
                $auth->assign($authorRole, $user->getId());

                return $user;
            }
        }

        return null;
    }
}
