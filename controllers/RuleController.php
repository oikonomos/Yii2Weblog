<?php

namespace app\controllers;

use Yii;
use app\models\AuthRule;
use app\models\AuthRuleSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\rbac\AuthorRule;

/**
 * RuleController implements the CRUD actions for AuthRule model.
 */
class RuleController extends MyController
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
                        //'roles' => ['?'],
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
     * Lists all AuthRule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthRuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthRule model.
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
     * Creates a new AuthRule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthRule();
        $auth = Yii::$app->authManager;
		
        if ($model->load(Yii::$app->request->post())) {
            // add the rule
            $ruleModel = $auth->getRule($model->name);
            if ($ruleModel === null) {
                    $ruleModel = new AuthorRule;
                    $ruleModel->name = $model->name;
                    $ruleModel->createdAt = time();
                    $auth->add($ruleModel);

                return $this->redirect(['view', 'id' => $model->name]);
            }
        } 
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

        /**
         * Updates an existing AuthRule model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
                $model = $this->findModel($id);
                $auth = Yii::$app->authManager;

                if ($model->load(Yii::$app->request->post())) {
                        $ruleModel = $auth->getRule($_POST['old_name']);
                        if ($ruleModel === null) {
                                $ruleModel = new AuthorRule;
                                $ruleModel->name = $model->name;
                                $ruleModel->createdAt = time();
                                $auth->add($ruleModel);
                        }
                        else {
                                $ruleModel->updatedAt = time();
                                $auth->update($_POST['old_name'], $ruleModel);
                        }

                        return $this->redirect(['view', 'id' => $model->name]);
                } 
                return $this->render('update', [
                        'model' => $model,
                ]);
        }

    /**
     * Deletes an existing AuthRule model.
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
     * Deletes an existing AuthItemChild model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $parent
     * @param string $child
     * @return mixed
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
     * Finds the AuthRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthRule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthRule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
