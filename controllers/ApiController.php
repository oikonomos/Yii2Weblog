<?php

namespace app\controllers;

use app\components\MyController;

/**
 * Description of ApiController
 * @author Yiiframework extention
 */
class ApiController extends MyController
{
        public function behaviors()
        {
                return [
                        // performs authorization by token
                        'tokenAuth' => [
                            'class' => \conquer\oauth2\TokenAuth::className(),
                        ],
                ];
        }
        
        public function beforeAction($action)
        {
                $this->enableCsrfValidation = false;
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return parent::beforeAction($action);
        }
        
        /**
         * Returns username and email
         */
        public function actionIndex()
        {
                $user = \Yii::$app->user->identity;
                return [
                        'username' => $user->username,
                        'email' =>  $user->email,
                ];
        }
}
