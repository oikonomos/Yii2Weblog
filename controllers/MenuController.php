<?php

namespace app\controllers;

use Yii;
use app\models\Menu;
use app\models\MenuSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use app\models\SearchForm;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends MyController
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
         * Lists all Menu models.
         * @return mixed
         */
        public function actionIndex()
        {
                $searchModel = new MenuSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single Menu model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id)
        {
                $model = $this->findModel($id);
                $model->setUnserializedMenuActive();
                
                return $this->render('view', [
                        'model' => $model,
                ]);
        }

        /**
         * Creates a new Menu model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
                $model = new Menu();

                if ($model->load(Yii::$app->request->post())) {
                        $model->owner_id = Yii::$app->user->id;
                        if ( !$model->parent ) {
                                $model->parent = 0;
                        }
                        if ($model->save())
                                return $this->redirect(['view', 'id' => $model->menu_id]);
                }
                
                return $this->render('create', [
                        'model' => $model,
                ]);
        }

        /**
         * Updates an existing Menu model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
                $model = $this->findModel($id);
                $model->setUnserializedMenuActive();

                if ($model->load(Yii::$app->request->post())) {
                        if ( !$model->parent ) {
                                $model->parent = 0;
                        }
                        if ($model->save())
                                return $this->redirect(['view', 'id' => $model->menu_id]);
                }
                
                return $this->render('create', [
                        'model' => $model,
                ]);
        }

        /**
         * Deletes an existing Menu model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id)
        {
                $this->findModel($id)->delete();

                return $this->redirect(['index']);
        }

        /**
         * Deletes an selected Menu models.
         * If deletion is successful, the browser will be redirected to the 'index' page.
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
         * Finds the Menu model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Menu the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
                if (($model = Menu::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }
}
