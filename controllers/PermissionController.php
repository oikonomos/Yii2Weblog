<?php

namespace app\controllers;

use Yii;
use app\models\AuthItem;
use app\models\AuthItemSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PermissionController implements the CRUD actions for AuthItem model.
 */
class PermissionController extends MyController
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
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
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();
        $auth = Yii::$app->authManager;

        if ($model->load(Yii::$app->request->post())) {
            if ($auth->getPermission($model->name) === null) {
                $authItem = $auth->createPermission($model->name);
                $authItem->type = $model->type;
                $authItem->description = $model->description;
                if ($model->rule_name) {
                    $rule = $auth->getRule($model->rule_name);
                    if ($rule !== null)
                        $authItem->ruleName = $rule->name;
                }
                $auth->add($authItem);
            
                return $this->redirect(['view', 'id' => $model->name]);
            }
        } 
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $auth = Yii::$app->authManager;

        if ($model->load(Yii::$app->request->post())) {
            $authItem = $auth->getPermission($model->name);
            if ($authItem === null) {
                $authItem = new \yii\rbac\Permission();
                $authItem->name = $model->name;
            }
            
            $authItem->type = $model->type;
            $authItem->description = $model->description;
            if ($model->rule_name) {
                $rule = $auth->getRule($model->rule_name);
                if ($rule !== null)
                    $authItem->ruleName = $rule->name;
            }
            $auth->update($_POST['old_name'], $authItem);
             
            return $this->redirect(['view', 'id' => $model->name]);            
        } 
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $item = $auth->getPermission($id);
        $auth->remove($item);

        return $this->redirect(['index']);
    }

    /**
     * Delete all of selected AuthItem models.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDeleteall()
    {
        $auth = Yii::$app->authManager;
        $ids = explode( '|', Yii::$app->request->get('ids') );
        if (is_array( $ids )) {
            foreach ( $ids as $id ) {
                $item = $auth->getPermission($id);
                $auth->remove($item);
            }
        }
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
