<?php

namespace app\controllers;

use Yii;
use app\models\Media;
use app\models\MediaSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use app\models\SearchForm;

/**
 * MediaController implements the CRUD actions for Media model.
 */
class MediaController extends MyController
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
         * Lists all Media models.
         * @return mixed
         */
        public function actionIndex()
        {
                $searchForm = new SearchForm();
                $searchModel = new MediaSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single Media model.
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
         * Creates a new Media model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new Media();

            if ( Yii::$app->request->isPost ) {
                        $model->upfile = UploadedFile::getInstance($model, 'upfile');
                        $model->caption = $_POST['Media']['caption'];
                        $model->description = $_POST['Media']['description'];

                        if ($model->upload('uploads/media')) {                
                                unset($model->upfile);
                                if ( $model->save() ) {
                                        return $this->redirect(['view', 'id' => $model->media_id]);
                                }
                        }
            }

            return $this->render('create', [
                    'model' => $model,
                ]);
        }

        /**
         * Multiple file upload
         * @return mixed
         */
        public function actionUpload()
        {
                $model = new Media();
                $model->upfile = UploadedFile::getInstance($model, 'upfile');

                if ( $model->upfile ) {
                        $model->upload();
                        if ($model->save()) {
                                return Json::encode([
                                        'files' => [
                                                [
                                                        'name' => $model->display_filename,
                                                        'size' => $model->file_size,
                                                        'url' => $model->file_url,
                                                        'thumbnailUrl' => $model->thumb_url,
                                                        'deleteUrl' => Url::to(['/media/mdelete/', 'id'=>$model->media_id]),
                                                        'deleteType' => 'POST',
                                                ],
                                        ],
                                ]);
                        }

                        return '';

                }

                return $this->render('upload', [
                            'model' => $model,
                ]);
        }

        /**
         * Updates an existing Media model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
                $model = $this->findModel($id);

                if ( Yii::$app->request->isPost ) {
                    $model->upfile = UploadedFile::getInstance($model, 'upfile');
                    $model->caption = $_POST['Media']['caption'];
                    $model->description = $_POST['Media']['description'];
                    $oldFilename = $model->filename;

                    if ($model->upload('uploads/media', 'update')) {
                        unset($model->upfile);
                        if ( $model->save() ) {
                            if ( file_exists($model->file_path . DIRECTORY_SEPARATOR . $oldFilename) )
                                @unlink ($model->file_path . DIRECTORY_SEPARATOR . $oldFilename);
                            if ( file_exists($model->thumb_path . DIRECTORY_SEPARATOR . $oldFilename) )
                                @unlink ($model->thumb_path . DIRECTORY_SEPARATOR . $oldFilename);

                            return $this->redirect(['view', 'id' => $model->media_id]);
                        }
                    }
                }        

                return $this->render('update', [
                    'model' => $model,
                ]);
        }

        /**
         * Deletes an existing Media model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param string $id
         * @return mixed
         */
        public function actionDelete($id)
        {
                $model = $this->findModel($id);    
                if (!$this->filterCheckAuthority($model))
                        $this->errorHandler();        
                        $model->delete();

                return $this->redirect(['index']);
        }

        /**
         * Deletes an existing Media model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param string $id
         * @return mixed
         */
        public function actionMdelete($id)
        {
                $model = $this->findModel($id);
                if ( $model->delete() ) {
                    $output['files'][] = [
                        'name' => $model->display_filename,
                        'size' => $model->file_size,
                        'url' => $model->file_url,
                        'thumbnailUrl' => $model->thumb_url,
                        'deleteUrl' => Url::to(['/media/mdelete/', 'id'=>$model->media_id]),
                        'deleteType' => 'POST',
                    ];
                }

                return Json::encode($output);
        }

        /**
         * Delete all of selected Media models.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         */
        public function actionDeleteall()
        {
                $ids = explode( '|', Yii::$app->request->get('ids') );
                if (is_array( $ids )) {
                        foreach ( $ids as $id ) {
                                if ($id) {
                                        $model = $this->findModel($id);
                                        if ($this->filterCheckAuthority($model)) {
                                                $model->delete();
                                        }
                                }
                        }
                }

                return $this->redirect(['index']);
        }

        /**
         * Finds the Media model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param string $id
         * @return Media the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
                if (($model = Media::findOne($id)) !== null) {
                    return $model;
                } else {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
        }

        /**
         * Attach an existing Media model.
         */
        public function actionAttach()
        {
                $resultSet = array();
                $where = null;

                if ( isset( $_GET['cpage'] ) ) {
                        $start = ( $_GET['cpage'] - 1 ) * 80;
                }
                else { 	
                        $start = 0;
                }

                if ('author' == Yii::$app->user->role) {
                        $where = sprintf("owner_id = %d", Yii::$app->user->id);
                }
                
                if ( isset( $_GET['mstx'] ) && $_GET['mstx'] ) {
                        if (!$where) {
                                $where = "display_filename like '%" . $_GET['mstx'] . "%'";
                        }
                        else {
                                $where .= " AND display_filename like '%" . $_GET['mstx'] . "%'";
                        }
                }

                if ( isset( $_GET['type'] ) && $_GET['type'] != "all" ) {
                        if (!$where) {
                                $where = "file_type like '%" . $_GET['type'] . "%'";
                        }
                        else {
                                $where .= " AND file_type like '%" . $_GET['type'] . "%'";
                        }
                        $type = $_GET[ 'type' ]; 
                }
                else {
                        if (!$where) {
                                $where = "1";
                        }
                        $type = 'all';
                }        

                $sql = sprintf("SELECT media_id, display_filename, thumb_url, thumb_width, thumb_height FROM %s WHERE %s ORDER BY created_at DESC LIMIT %d, 80", Media::tableName(), $where, $start);
                $sql_count = sprintf("SELECT COUNT(*) as total FROM %s WHERE %s", Media::tableName(), $where);

                $command = Yii::$app->db->createCommand($sql);
                $resultSet['data'] = $command->queryAll();
                $command = Yii::$app->db->createCommand($sql_count);
                $row = $command->queryOne();
                $resultSet['pages'] = ceil( $row['total'] / 80 );
                $resultSet[ 'type' ] = $type;
                $resultSet[ 'mstx' ] = (isset($_GET['mstx'])) ? $_GET['mstx'] : '';

                echo \yii\helpers\Json::encode($resultSet);
        }
}
