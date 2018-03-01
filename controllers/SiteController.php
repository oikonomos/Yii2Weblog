<?php
namespace app\controllers;

use Yii;
use app\components\MyController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\PostSearch;

/**
 * Site controller
 */
class SiteController extends MyController
{

        /**
         * @inheritdoc
         */
        public function behaviors()
        {
                return [
                        'access' => [
                                'class' => AccessControl::className(),
                                'rules' => [
                                        [
                                                'actions' => ['login', 'signup',  'error', 'index', 'contact', 'about', 'termsofuse', 'privacy', 'captcha'],
                                                'allow' => true,
                                        ],
                                        [
                                                'actions' => ['logout', 'dashboard', 'dashboard2', 'gsearch'],
                                                'allow' => true,
                                                'roles' => ['@'],
                                        ],
                                ],
                        ],
                        'verbs' => [
                                'class' => VerbFilter::className(),
                                'actions' => [
                                        'logout' => ['post'],
                                ],
                        ],
                ];
        }

        /**
         * @inheritdoc
         */
        public function actions()
        {
                return [
                        'error' => [
                                'class' => 'yii\web\ErrorAction',
                        ],
                        'captcha' => [
                                'class' => 'yii\captcha\CaptchaAction',
                                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                        ],
                ];
        }

        /**
         * Displays homepage.
         *
         * @return string
         */
        public function actionIndex()
        {
                return $this->render('index');
        }

        /**
         * Displays dashboard.
         *
         * @return string
         */
        public function actionDashboard()
        {
                $this->layout = "admin";                
                
                $splitDate = explode('-', date('Y-m-d'));
                $dataSetByHour = \app\models\WebsightLogCounter::getHourlyDataSet($splitDate[0], $splitDate[1], $splitDate[2]);
                $dataSetByDay = \app\models\WebsightLogCounter::getDailyDataSet($splitDate[0], $splitDate[1]);
                $dataSetByMonth = \app\models\WebsightLogCounter::getMonthlyDataSet($splitDate[0]);
                $dataSetByYear = \app\models\WebsightLogCounter::getYearlyDataSet();
                
                return $this->render('dashboard', [
                        'dataSetByHour' => $dataSetByHour,
                        'dataSetByDay' => $dataSetByDay,
                        'dataSetByMonth' => $dataSetByMonth,
                        'dataSetByYear' => $dataSetByYear
                ]);
        }
        /**
         * Displays dashboard.
         *
         * @return string
         */
        public function actionDashboard2()
        {
                $this->layout = "admin";                
                
                $splitDate = explode('-', date('Y-m-d'));
                $dataSetByHour = \app\models\WebsightLogCounter::getHourlyDataSet($splitDate[0], $splitDate[1], $splitDate[2]);
                $dataSetByDay = \app\models\WebsightLogCounter::getDailyDataSet($splitDate[0], $splitDate[1]);
                $dataSetByMonth = \app\models\WebsightLogCounter::getMonthlyDataSet($splitDate[0]);
                $dataSetByYear = \app\models\WebsightLogCounter::getYearlyDataSet();
                
                return $this->render('dashboard2', [
                    'dataSetByHour' => $dataSetByHour,
                    'dataSetByDay' => $dataSetByDay,
                    'dataSetByMonth' => $dataSetByMonth,
                    'dataSetByYear' => $dataSetByYear
                ]);
        }

        /**
         * Login action.
         *
         * @return string
         */
        public function actionLogin()
        {
                if (!Yii::$app->user->isGuest) {
                        return $this->goHome();
                }

                $model = new LoginForm();
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                        return $this->goBack();
                } else {
                        return $this->render('login', [
                                'model' => $model,
                        ]);
                }
        }

        /**
         * Logout action.
         *
         * @return string
         */
        public function actionLogout()
        {
                Yii::$app->user->logout();

                return $this->goHome();
        }

        /**
         * Displays contact page.
         *
         * @return string
         */
        public function actionContact()
        {
                $model = new ContactForm();
                if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
                        Yii::$app->session->setFlash('contactFormSubmitted');

                        return $this->refresh();
                }
                return $this->render('contact', [
                        'model' => $model,
                ]);
        }

        /**
         * Displays about page.
         *
         * @return string
         */
        public function actionAbout()
        {
                return $this->render('about');
        }

        /**
         * Displays privacy page.
         *
         * @return string
         */
        public function actionPrivacy()
        {
                $model = \app\models\Option::findOne([ 'name' => 'site-privacy' ]);
                return $this->render('privacy', [
                        'model' => $model
                ]);
        }
        
        /**
         * Displays termsofuse page.
         *
         * @return string
         */
        public function actionTermsofuse()
        {
                $model = \app\models\Option::findOne([ 'name' => 'site-termsofuse' ]);
                return $this->render('termsofuse', [
                        'model' => $model
                ]);
        }

        /**
         * Signs user up.
         * @return mixed
         */
        public function actionSignup()
        {
                if (Yii::$app->user->isGuest) {
                        $model = new SignupForm();
                        if ($model->load(Yii::$app->request->post())) {
                                if ($user = $model->signup()) {
                                        if (Yii::$app->getUser()->login($user)) {
                                                return $this->goHome();
                                        }
                                }
                        }

                        return $this->render('signup', [
                                'model' => $model,
                        ]);
                }
                else {
                        $this->redirect(['index']);
                }
        }

        /**
         * Requests password reset.
         * @return mixed
         */
        public function actionRequestPasswordReset()
        {
                $model = new PasswordResetRequestForm();
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                        if ($model->sendEmail()) {
                                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

                                return $this->goHome();
                        } else {
                                Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
                        }
                }

                return $this->render('requestPasswordResetToken', [
                        'model' => $model,
                ]);
        }

        /**
         * Resets password.
         *
         * @param string $token
         * @return mixed
         * @throws BadRequestHttpException
         */
        public function actionResetPassword($token)
        {
                try {
                        $model = new ResetPasswordForm($token);
                } catch (InvalidParamException $e) {
                        throw new BadRequestHttpException($e->getMessage());
                }

                if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved.'));

                        return $this->goHome();
                }

                return $this->render('resetPassword', [
                        'model' => $model,
                ]);
        }   

        /**
         * Error Handler.
         */
        public function actionError()
        {
                $message = Yii::$app->request->get('message');
                $name = Yii::$app->request->get('name');
                $exception = Yii::$app->errorHandler->exception;
                if ($exception !== null) {
                        return $this->render('error', [
                                'exception' => $exception,
                                'name' => $name,
                                'message' => $message,
                        ]);
                }
        }   

        /**
         * Error Handler.
         */
        public function actionHandler()
        {
                $message = Yii::$app->request->get('msg');
                $name = Yii::$app->request->get('name');
                return $this->render('error_handler', [
                        'name' => $name,
                        'message' => $message,
                ]);
        }
        
        /**
         * Site Search.
         */
        public function actionGsearch() {      
                $searchModel = new PostSearch();
                $gstx = Yii::$app->request->get('gstx');
                $params['PostSearch']['title'] = $gstx;
                $params['PostSearch']['content'] = $gstx;
                $params['PostSearch']['tags'] = $gstx;
                $dataProvider = $searchModel->gsearch($params);

                return $this->render('gsearch', [
                        'gstx' => $gstx,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
        }
}
