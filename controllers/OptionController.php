<?php

namespace app\controllers;

use Yii;
use app\models\Option;
use app\models\OptionSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * OptionController implements the CRUD actions for Option model.
 */
class OptionController extends MyController
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
         * Lists all Option models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new OptionSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single Option model.
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
         * Creates a new Option model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new Option();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->option_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing Option model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->option_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing Option model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionSite()
        {
                if ( Yii::$app->request->isPost ) {
                        $site = Yii::$app->request->post("Site");
                        foreach ($site as $key => $value) {
                                $model = Option::findOne([ 'name' => $key ]);
                                if ($model === NULL) {
                                        $model = new Option();
                                        $model->name = $key;
                                        $model->value = $value;
                                }
                                else {
                                        $model->value = $value;
                                }
                                $model->save();
                                unset($model);
                        }

                } else {
                        $dataProvider = new ActiveDataProvider([
                                'query' => Option::find()->where("name like 'site-%'")->orderBy("name ASC"),
                                'pagination' => [
                                        'pagesize' => 100
                                ]
                        ]);
                        return $this->render('site', [
                                'dataProvider' => $dataProvider,
                        ]);
                }
        }

        /**
         * Updates an existing Option model.
         * If update is successful, the browser will be redirected to the 'config' page.
         * @return mixed
         */
        public function actionConfig()
        {
                if ( Yii::$app->request->isPost ) {
                        $options = Yii::$app->request->post("Option");
                        $model = new Option();
                        foreach ($options as $option) {
                                $model->load($option);
                                $model->save();
                        }
                }
                
                $dataProvider = new ActiveDataProvider([
                        'query' => Option::find()->where("name like 'conf-%'")->orderBy("name ASC"),
                        'pagination' => [
                                'pagesize' => 100
                        ]
                ]);
                
                return $this->render('config', [
                        'options' => $dataProvider->getModels(),
                ]);
        }

        /**
         * Deletes an existing Option model.
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
         * Delete all of selected Option models.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         */
        public function actionDeleteall()
        {
            $ids = explode( '|', Yii::$app->request->get('ids') );
            if (is_array( $ids )) {
                foreach ( $ids as $id ) {
                    $model = $this->findModel($id);
                    if ($this->filterCheckAuthority($model))
                        $model->delete();
                }
            }

            return $this->redirect(['index']);
        }

        /**
         * Finds the Option model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param string $id
         * @return Option the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Option::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
}
