<?php
namespace app\components;

use yii;
use yii\web\User;


/**
 * WebUser
 */
class WebUser extends User
{
        public $role = '';
        public $displayName = '';
        public $userphoto = null;
        public $isSuperAdmin = false;

        /**
         * initialize User
         */
        public function init()
        {
                parent::init();

                $this->setUserInfo();
        }

        /**
         * Set User Role
         */
        public function setUserInfo()
        {
                if ($this->id) {
                        $user =  \app\models\User::findOne($this->id);
                        $usermeta =  \app\models\Usermeta::findOne(['user_id' => $this->id, 'meta_key' => 'userphoto']);
                        $this->isSuperAdmin = $user->checkSuperAdmin();
                        
                        if ( $user !== null ) {
                                $this->displayName = $user->name;
                                $this->role = $user->role;
                        }
                        if ( $usermeta !== null ) {
                                $this->userphoto = unserialize($usermeta->meta_value);
                                if ( !is_array($this->userphoto) )
                                        $this->userphoto = ['', ''];
                        }
                }
                else {
                        $this->role = 'guest';
                }
        }
}
