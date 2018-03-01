<?php

namespace app\controllers;

use Yii;
use app\models\WebsightLog;
use app\models\WebsightLogSearch;
use app\models\WebsightLogBrowser;
use app\models\WebsightLogBrowserSearch;
use app\models\WebsightLogCounter;
use app\models\WebsightLogCounterSearch;
use app\models\WebsightLogDomain;
use app\models\WebsightLogDomainSearch;
use app\models\WebsightLogIp;
use app\models\WebsightLogIpSearch;
use app\models\WebsightLogKeyword;
use app\models\WebsightLogKeywordSearch;
use app\models\WebsightLogOs;
use app\models\WebsightLogOsSearch;
use app\models\WebsightLogPage;
use app\models\WebsightLogPageSearch;
use app\models\WebsightLogReferer;
use app\models\WebsightLogRefererSearch;
use app\models\WebsightLogSearchengin;
use app\models\WebsightLogSearchenginSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * StatisticsController implements the CRUD actions for WebsightLog model.
 */
class StatisticsController extends MyController
{
    public $layout = 'admin';
    
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all WebsightLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebsightLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogBrowser models.
     * @return mixed
     */
    public function actionBrowser()
    {
        $searchModel = new WebsightLogBrowserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('browser', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogCounter models.
     * @return mixed
     */
    public function actionCounter()
    {
        $searchModel = new WebsightLogCounterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('counter', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogDomain models.
     * @return mixed
     */
    public function actionDomain()
    {
        $searchModel = new WebsightLogDomainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('domain', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogIp models.
     * @return mixed
     */
    public function actionIp()
    {
        $searchModel = new WebsightLogIpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('ip', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogKeyword models.
     * @return mixed
     */
    public function actionKeyword()
    {
        $searchModel = new WebsightLogKeywordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('keyword', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogOs models.
     * @return mixed
     */
    public function actionOs()
    {
        $searchModel = new WebsightLogOsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('os', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogPage models.
     * @return mixed
     */
    public function actionPage()
    {
        $searchModel = new WebsightLogPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('page', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all WebsightLogReferer models.
     * @return mixed
     */
    public function actionReferer()
    {
        $searchModel = new WebsightLogRefererSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('referer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all WebsightLogSearchengin models.
     * @return mixed
     */
    public function actionSearchengin()
    {
        $searchModel = new WebsightLogSearchenginSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('searchengin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the WebsightLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WebsightLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsightLog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
