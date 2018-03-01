<?php

namespace app\controllers;

use Yii;
use app\models\Comment;
use app\models\CommentSearch;
use app\models\User;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CommentController implements the CRUD actions for Comment model.
 */
class CommentController extends MyController
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
         * Lists all Comment models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new CommentSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single Comment model.
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
         * Creates a new Comment model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new Comment();

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->co_id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing Comment model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->co_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing Comment model.
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
         * Delete all of selected Comment models.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         */
        public function actionDeleteall()
        {
            $ids = explode( '|', Yii::$app->request->get('ids') );
            if (is_array( $ids )) {
                foreach ( $ids as $id ) {
                    if ($id) {
                        $model = $this->findModel($id);
                        if ($this->filterCheckAuthority($model))
                            $model->delete();
                        }
                }
            }

            return $this->redirect(['index']);
        }  

        /**
         * Creates a new Comment model.
         * @return void
         */
        public function actionWrite()
        {
                $model = new Comment();
                
                $result = array();
                if ($this->filterCheckAuthority()) {
                        if ($model->load(Yii::$app->request->post())) {
                                $user = User::findOne($model->author_id);
                                $model->co_id = $this->getMaxId() + 1;
                                $model->writer = $user->name;
                                $model->parent = 0;
                                $model->ip = $_SERVER['REMOTE_ADDR'];
                                $model->group_id = $model->co_id;
                                $model->level = 0;
                                $model->sequence = 0;
                                if ($model->save()) {
                                        $result['co_id'] = $model->co_id;
                                        $result['name'] = $model->writer;
                                        $result['date'] = $model->created_at;
                                        $result['content'] = $model->content;

                                        $result['error'] = false;
                                        $result['msg'] = Yii::t('app', "Written coment was saved.");
                                }
                                else {
                                        $result['error'] = true;
                                        $result['msg'] = Yii::t('app', 'Failed to save comment written.');
                                }
                        }
                        else {
                            $result['error'] = true;
                            $result['msg'] = Yii::t('app', 'Error writing comment. Contact your administrator');
                        }
                }
                else {
                        $result['error'] = true;
                        $result['msg'] = Yii::t('app', 'You do not have the right to write comment.');
                }
                echo json_encode($result);
        }

        /**
         * Updates an existing Comment model.
         * @param integer $id
         * @return void
         */
        public function actionModify()
        {
                $result = array();
                $id = Yii::$app->request->post('co_id');
                $model = $this->findModel($id);  

                if ($this->filterCheckAuthority($model)) {
                        if ($model !== null) {
                                if ($model->content=Yii::$app->request->post('content')) {
                                        if ($model->save()) {
                                                $result['co_id'] = $model->co_id;
                                                $result['name'] = $model->writer;
                                                $result['date'] = $model->created_at;
                                                $result['content'] = $model->content;

                                                $result['error'] = false;
                                                $result['msg'] = Yii::t('app', 'Comment was updated.');
                                        }
                                        else {
                                                $result['error'] = true;
                                                $result['msg'] = Yii::t('app', 'Failed to update comment.');                        
                                        }
                                }
                                else {
                                        $result['error'] = true;
                                        $result['msg'] = Yii::t('app', 'Enter comment.');                        
                                }
                        }
                        else {
                                $result['error'] = true;
                                $result['msg'] =Yii::t('app', 'Error modifying comment. Contact your administrator.');
                        }
                }
                else {
                        $result['error'] = true;
                        $result['msg'] = Yii::t('app', 'You do not have the right to modify comment.');
                }
                echo json_encode($result);
        }

        /**
         * Delete an existing Comment model.
         * @param string $id
         * @return mixed
         */
        public function actionRemove()
        {
                $id = Yii::$app->request->post('co_id');
                $model = $this->findModel($id);
                $result = array();
                $result['co_id'] = $id;
                $result['error'] = true;
                if ($model !== null) {
                        if (!$this->filterCheckAuthority($model)) {
                                $result['msg'] = Yii::t('app', 'You do not have the right to delete comment.');
                        }
                        else {
                                $model->delete();
                                $result['error'] = false;
                                $result['msg'] = Yii::t('app', 'Comment has been deleted.');
                        }
                }
                else {
                        $result['msg'] = Yii::t('app', 'Failed deleting comment. Contact your administrator.');
                }

                echo json_encode($result);
        }

        /**
         * Delete an existing Comment model.
         * @param string $id
         * @return mixed
         */
        public function actionGet()
        {
                $id = Yii::$app->request->post('co_id');

                $model = $this->findModel($id);
                $result = array();
                $result['co_id'] = $id;
                $result['error'] = true;

                if ($model !== null) {
                        if (!$this->filterCheckAuthority($model)) {
                                $result['msg'] = Yii::t('app', 'You do not have the right to modify comment.');
                        }
                        else {
                                $result['co_id'] = $model->co_id;
                                $result['name'] = $model->writer;
                                $result['post_id'] = $model->post_id;
                                $result['author_id'] = $model->author_id;
                                $result['date'] = $model->created_at;
                                $result['content'] = $model->content;
                                $result['error'] = false;
                                $result['msg'] = "";
                        }
                }
                else {
                        $result['msg'] = Yii::t('app', 'Unable to modify comment. Contact your administrator.');
                }

                echo json_encode($result);
        }

        /**
         * Finds the Comment model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param string $id
         * @return Comment the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Comment::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException( Yii::t('app', 'The requested page does not exist.') );
            }
        }

        /**
         * Update the sequence in the group models.
         * @param bigint $group_id the group_id of the model
         * @param integer $sequence the sequence of the model
         * @return integer number of rows affected by command
         */
        protected function updateOrder($post_id_, $group_id, $sequence)
        {
            $sql = sprintf("update %s set sequence=sequence+1 where post_id=%d && group_id=%s && sequence>%s", Comment::tableName(), $post_id, $group_id, $sequence);
            $command = Yii::$app->db->createCommand($sql);
            return $command->execute();
        }

        /**
         * Get Max id in the total models.
         * @return bigint max id
         */
        protected function getMaxId()
        {
            $sql = sprintf("select MAX(co_id) as max_id from %s", Comment::tableName());
            $command = Yii::$app->db->createCommand($sql);
            $row = $command->queryOne();
            return $row[ 'max_id' ];
        }
}
