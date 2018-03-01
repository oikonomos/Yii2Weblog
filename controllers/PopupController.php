<?php

namespace app\controllers;

use Yii;
use app\models\Popup;
use app\models\PopupSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PopupController implements the CRUD actions for Popup model.
 */
class PopupController extends MyController
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
                                        'actions' => ['cookie'],
                                        'allow' => true,
                                ],
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
                                'deleteall' => ['GET'],
                        ],
                ],
        ];
    }

    /**
     * Lists all Popup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PopupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Popup model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Popup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Popup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->popup_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Popup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->popup_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
        /**
         * Set popup cookie. 
         */
        public function actionCookie() {
                $cookies = Yii::$app->response->cookies;
                $today = explode("-", date("Y-m-d"));
                $period = mktime(23, 59, 59, (int)$today[1], (int)$today[2], (int)$today[0]);
                
                $cookie = new \yii\web\Cookie([
                                        'name' => 'popupid',
                                        'value' => md5($_POST['popupid']),
                                        'expire' => $period
                                ]);
                $ret = [
                        'message' => 'error',
                ];
                
                if (Yii::$app->request->isPost) {
                        if ( isset($_POST['popupid']) ) {
                                $cookies->add( $cookie );
                                $ret['message'] = 'success';
                        }
                }
                //$ret['cookie'] = $cookies->get('popupid');
                echo json_encode($ret);
                Yii::$app->end();
        }

    /**
     * Deletes an existing Popup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Delete all of selected Popup models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDeleteall()
    {
        $ids = explode( '|', Yii::$app->request->get('ids') );
        if (is_array( $ids )) {
            foreach ( $ids as $id ) {
                $this->findModel($id)->delete();
            }
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Popup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Popup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Popup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
