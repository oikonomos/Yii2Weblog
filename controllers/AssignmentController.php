<?php

namespace app\controllers;

use Yii;
use app\models\AuthAssignment;
use app\models\AuthAssignmentSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AssignmentController implements the CRUD actions for AuthAssignment model.
 */
class AssignmentController extends MyController
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
                    'deleteall' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthAssignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthAssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthAssignment model.
     * @param string $item_name
     * @param string $user_id
     * @return mixed
     */
    public function actionView($item_name, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($item_name, $user_id),
        ]);
    }

        /**
         * Creates a new AuthAssignment model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
                $model = new AuthAssignment();
                $auth = Yii::$app->authManager;

                if ($model->load(Yii::$app->request->post())) {
                        if (!$auth->getAssignment($model->item_name, $model->user_id)) {
                                $role = $auth->getRole($model->item_name);
                                if ($role === null) {
                                        $role = $auth->createRole($model->item_name);
                                        $auth->assign($role, $model->user_id);
                                }

                                return $this->redirect(['view', 'id[item_name]' => $model->item_name, 'id[user_id]' => $model->user_id]);
                        }
                } 

                return $this->render('create', [
                        'model' => $model,
                ]);
        }

        /**
         * Updates an existing AuthAssignment model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $item_name
         * @param string $user_id
         * @return mixed
         */
        public function actionUpdate($item_name, $user_id)
        {
                $model = $this->findModel($item_name, $user_id);
                $auth = Yii::$app->authManager;

                if ($model->load(Yii::$app->request->post())) {
                        if (!$auth->getAssignment($model->item_name, $model->user_id)) {
                                $role = $auth->getRole($model->item_name);
                                if ($role !== null) {
                                        $model->save();
                                }

                                return $this->redirect(['view', 'id[item_name]' => $model->item_name, 'id[user_id]' => $model->user_id]);
                        }
                } 

                return $this->render('update', [
                        'model' => $model,
                ]);
        }

    /**
     * Deletes an existing AuthAssignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $item_name
     * @param string $user_id
     * @return mixed
     */
    public function actionDelete($item_name, $user_id)
    {
        $this->findModel($item_name, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Delete all of selected AuthAssignment models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDeleteall()
    {
        $auth = Yii::$app->authManager;
        $ids = explode( '|', Yii::$app->request->get('ids') );
        if (is_array( $ids )) {
            foreach ( $ids as $id ) {
                $obj = json_decode($id);
                //var_dump($obj);
                $this->findModel($obj->item_name, $obj->user_id)->delete();
            }
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthAssignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $item_name
     * @param string $user_id
     * @return AuthAssignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($item_name, $user_id)
    {
        if (($model = AuthAssignment::findOne(['item_name' => $item_name, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
