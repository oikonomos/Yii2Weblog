<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use app\models\Postmeta;
use app\models\TermTaxonomy;
use app\models\SearchForm;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends MyController
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
                                'actions' => ['gallery', 'gview', 'list', 'lview'],
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
         * Lists all Post models.
         * @return mixed
         */
        public function actionIndex()
        {
                $searchForm = new SearchForm();
                $searchModel = new PostSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Lists all Post models.
         * @return mixed
         */
        public function actionList()
        {
                $this->layout = 'main';
                $searchForm = new SearchForm();
                $searchModel = new PostSearch();
                
                $tt_id = Yii::$app->request->get('tt_id');
                
                if ( isset($tt_id) && $tt_id ) {
                    $taxonomy = TermTaxonomy::findOne( $tt_id );
                    $taxonomy->setNameNSlug();
                }
                else
                {
                    throw new NotFoundHttpException(Yii::t('app', 'There is no category.'));
                }
                $searchModel->tt_id = $tt_id;
                
                $params = [];
                if (Yii::$app->request->isPost) {
                        $searchForm->load(Yii::$app->request->post());
                        if ($searchForm->validate())
                                $params['PostSearch'][$searchForm->sfld] = $searchForm->stx;
                }
                
                $dataProvider = $searchModel->searchByTaxonomy($params);

                return $this->render('list', [
                        'searchForm' => $searchForm,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'taxonomy' => $taxonomy
                ]);
        }

        /**
         * Lists all Post models.
         * @return mixed
         */
        public function actionPage()
        {
                $searchForm = new SearchForm();
                $searchModel = new PostSearch();
                $dataProvider = $searchModel->pgsearch(Yii::$app->request->queryParams);

                return $this->render('page', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Lists all Post models.
         * @return mixed
         */
        public function actionGallery()
        {
                $this->layout = 'main';
                $searchForm = new SearchForm();
                $searchModel = new PostSearch();
                
                $tt_id = Yii::$app->request->get('tt_id');
                
                if ( isset($tt_id) && $tt_id ) {
                    $taxonomy = TermTaxonomy::findOne( $tt_id );
                    $taxonomy->setNameNSlug();
                }
                else
                {
                    throw new NotFoundHttpException(Yii::t('app', 'There is no category.'));
                }
                $searchModel->tt_id = $tt_id;                
                $params = [];
                if (Yii::$app->request->isPost) {
                        $searchForm->load(Yii::$app->request->post());
                        if ($searchForm->validate())
                                $params['PostSearch'][$searchForm->sfld] = $searchForm->stx;
                }
                
                $dataProvider = $searchModel->searchByTaxonomy($params);

                return $this->render('gallery', [
                        'searchForm' => $searchForm,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'taxonomy' => $taxonomy
                ]);
        }

        /**
         * Displays a single Post model.
         * @param string $id
         * @return mixed
         */
        public function actionView($id)
        {
                $model = $this->findModel($id);
                $termArr = $model->getTerm()->all();
                $model->termname = $termArr[0]->name;
                $model->setPostmetas();
                $model->attachments = $model->getAttachmentsToTags($model->attachment);
                
                return $this->render('view', [
                    'model' => $model,
                ]);
        }

        /**
         * Displays a single Post model.
         * @param string $id
         * @return mixed
         */
        public function actionLview($id)
        {
                $this->layout = 'main';               
                
                $tt_id = Yii::$app->request->get('tt_id');
                if ( isset($tt_id) && $tt_id ) {
                    $taxonomy = TermTaxonomy::findOne( $tt_id );
                    $taxonomy->setNameNSlug();
                }
                else
                {
                    throw new NotFoundHttpException(Yii::t('app', 'There is no category.'));
                }
                $model = $this->findModel($id);
                $model->setPostmetas();
                $this->increaseHitCount($model->po_id);
                return $this->render('lview', [
                        'model' => $model,
                        'taxonomy' => $taxonomy
                ]);
        }

        /**
         * Displays a single Post model.
         * @param string $id
         * @return mixed
         */
        public function actionGview($id)
        {
                $this->layout = 'main';               
                
                $tt_id = Yii::$app->request->get('tt_id');
                if ( isset($tt_id) && $tt_id ) {
                        $taxonomy = TermTaxonomy::findOne( $tt_id );
                        $taxonomy->setNameNSlug();
                }
                else
                {
                    throw new NotFoundHttpException(Yii::t('app', 'There is no category.'));
                }
                
                $model = $this->findModel($id);
                $model->setPostmetas();
                $this->increaseHitCount($model->po_id);
                return $this->render('gview', [
                        'model' => $model,
                        'taxonomy' => $taxonomy
                ]);
        }

        /**
         * Displays a single Post model.
         * @param string $id
         * @return mixed
         */
        public function actionPview($id)
        {
                $model = $this->findModel($id);
                $model->setPostmetas();
                $this->increaseHitCount($model->po_id);
                
                return $this->render('pview', [
                    'model' => $model,
                ]);
        }

        /**
         * Creates a new Post model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
                $model = new Post();

                if ($id = Yii::$app->user->getId()) {
                        $user = \app\models\User::findOne($id);
                        $model->author_id = $user->id;
                        $model->email = $user->email;
                        $model->writer = $user->name;
                }

                if ($model->load(Yii::$app->request->post())) {

                        $model->po_id = $this->getMaxId() + 1;
                        $model->excerpt = $this->excerpt($model->content);

                        // Begin transaction
                        $transaction = Yii::$app->db->beginTransaction();

                        if ($model->term_taxonomy_id) {
                            $taxonomy = TermTaxonomy::findOne($model->term_taxonomy_id);
                            $taxonomy->count++;
                            $taxonomy->save();
                        }

                        try {
                                if ($model->parent) {
                                        $parentModel = Post::findOne($model->parent);
                                        $model->group_id = $parentModel->group_id;
                                        $model->level = $parentModel->level + 1;
                                        $model->sequence = $parentModel->sequence + 1;
                                        $this->updateOrder($parentModel->group_id, $parentModel->sequence);
                                }
                                else {
                                        $model->group_id = $model->po_id;
                                        $model->level = 0;
                                        $model->sequence = 0;
                                }

                                if (!$model->author_id) {
                                        $model->author_id= Yii::$app->user->id; 
                                }

                                if ($model->save()) {                    
                                    $metas = array();
                                    if (isset($_POST['attachment']) || isset($_POST['Postmeta'])) {
                                        if (isset($_POST['attachment'])) {
                                            $metas['attachment'] = serialize($_POST['attachment']);
                                        }

                                        if (isset($_POST['Postmeta'])) {
                                            $metas = array_merge($metas, $_POST['Postmeta']);
                                        }

                                        $model->savePostmetas($metas);
                                    }

                                    // Commit
                                    $transaction->commit();

                                    return $this->redirect(['view', 'id' => $model->po_id]);
                                }
                                else {
                                    $transaction->rollback();
                                    print_r($model);
                                }
                            }
                        catch (Exception $ex) {
                            // Rollback
                            $transaction->rollback();
                            echo "Query Error" . PHP_EOL;
                            echo $ex->getMessage();                
                        }
                        catch (\yii\db\Exception $sqlEx) {
                            // Rollback
                            $transaction->rollback();
                            echo "Query Error" . PHP_EOL;
                            echo $sqlEx->getMessage();                
                        }

                // Model 에러 체크
                //echo "<pre>";
                //print_r($model->getErrors());
                //echo "</pre>";
                } else {
                        return $this->render('create', [
                                'model' => $model,
                        ]);
                }
        }

        /**
         * Updates an existing Post model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
                $model = $this->findModel($id);    
                if ($this->filterCheckAuthority($model)) {
                        if ($model->load(Yii::$app->request->post())) {

                                $model->excerpt = $this->excerpt($model->content);

                                // Begin transaction
                                $transaction = Yii::$app->db->beginTransaction();

                                if ($model->term_taxonomy_id != $_POST['old_term_taxonomy_id']) {
                                        $prevTaxonomy= TermTaxonomy::findOne($_POST['old_term_taxonomy_id']);
                                        $prevTaxonomy->count--;
                                        $prevTaxonomy->save();
                                        $taxonomy = TermTaxonomy::findOne($model->term_taxonomy_id);
                                        $taxonomy->count++;
                                        $taxonomy->save();
                                }

                                if (!$model->author_id) {
                                        $model->author_id= Yii::$app->user->id; 
                                }

                                try {                
                                        if ($model->save()) {
                                                // Commit
                                                $transaction->commit();

                                                $metas = array();
                                                if (isset($_POST['attachment']) || isset($_POST['Postmeta'])) {
                                                        if (isset($_POST['attachment'])) {
                                                                $metas['attachment'] = serialize($_POST['attachment']);
                                                        }

                                                        if (isset($_POST['Postmeta'])) {
                                                                $metas = array_merge($metas, $_POST['Postmeta']);
                                                        }

                                                        $model->savePostmetas($metas);
                                                }

                                                return $this->redirect(['view', 'id' => $model->po_id]);
                                            }                
                                } catch (Exception $ex) {
                                       // Rollback
                                       $transaction->rollback();
                                       echo $ex->getMessage();                
                               }
                        } else {
                                $model->setPostmetas();
                                return $this->render('update', [
                                        'model' => $model,
                                ]);
                        }
                }
                else {            
                        $this->errorHandler();
                }
        }

        /**
         * Creates a new Post model.
         * If creation is successful, the browser will be redirected to the 'pgview' page.
         * @return mixed
         */
        public function actionPcreate()
        {
            $model = new Post();

            if ($id = Yii::$app->user->getId()) {
                $user = \app\models\User::findOne($id);
                $model->author_id = $user->id;
                $model->email = $user->email;
                $model->writer = $user->name;
            }

            if ($model->load(Yii::$app->request->post())) {

                $model->po_id = $this->getMaxId() + 1;
                $model->excerpt = $this->excerpt($model->content);
                $model->term_taxonomy_id = 0;

                // Begin transaction
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    if ($model->parent) {
                        $parentModel = Post::findOne($model->parent);
                        $model->group_id = $parentModel->group_id;
                        $model->level = $parentModel->level + 1;
                        $model->sequence = $parentModel->sequence + 1;
                        $this->updateOrder($parentModel->group_id, $parentModel->sequence);
                    }
                    else {
                        $model->group_id = $model->po_id;
                        $model->level = 0;
                        $model->sequence = 0;
                    }

                    if (!$model->author_id) {
                        $model->author_id= Yii::$app->user->id; 
                    }

                    if ($model->save()) {                    
                        $metas = array();
                        if (isset($_POST['attachment']) || isset($_POST['Postmeta'])) {
                            if (isset($_POST['attachment'])) {
                                $metas['attachment'] = serialize($_POST['attachment']);
                            }

                            if (isset($_POST['Postmeta'])) {
                                $metas = array_merge($metas, $_POST['Postmeta']);
                            }

                            $model->savePostmetas($metas);
                        }

                        // Commit
                        $transaction->commit();

                        return $this->redirect(['pview', 'id' => $model->po_id]);
                    }
                    else {
                        $transaction->rollback();
                        print_r($model);
                    }
                }
                catch (Exception $ex) {
                    // Rollback
                    $transaction->rollback();
                    echo "Query Error" . PHP_EOL;
                    echo $ex->getMessage();                
                }
                catch (\yii\db\Exception $sqlEx) {
                    // Rollback
                    $transaction->rollback();
                    echo "Query Error" . PHP_EOL;
                    echo $sqlEx->getMessage();                
                }

            } else {
                return $this->render('pcreate', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing Post model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionPupdate($id)
        {
            $model = $this->findModel($id);    
            if ($this->filterCheckAuthority($model)) {
                if ($model->load(Yii::$app->request->post())) {

                    $model->excerpt = $this->excerpt($model->content);

                    // Begin transaction
                    $transaction = Yii::$app->db->beginTransaction();

                    if (!$model->author_id) {
                        $model->author_id= Yii::$app->user->id; 
                    }

                    try {                
                        if ($model->save()) {
                            // Commit
                            $transaction->commit();

                            $metas = array();
                            if (isset($_POST['attachment']) || isset($_POST['Postmeta'])) {
                                if (isset($_POST['attachment'])) {
                                    $metas['attachment'] = serialize($_POST['attachment']);
                                }

                                if (isset($_POST['Postmeta'])) {
                                    $metas = array_merge($metas, $_POST['Postmeta']);
                                }

                                $model->savePostmetas($metas);
                            }

                            return $this->redirect(['view', 'id' => $model->po_id]);
                        }                
                    } catch (Exception $ex) {
                        // Rollback
                        $transaction->rollback();
                        echo $ex->getMessage();                
                    }
                } else {
                    return $this->render('pupdate', [
                        'model' => $model,
                    ]);
                }
            }
            else {            
                $this->errorHandler();
            }
        }

        /**
         * Deletes an existing Post model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param string $id
         * @return mixed
         */
        public function actionDelete($id)
        {
                $model = $this->findModel($id);
                $model->delete();

                if ($model->term_taxonomy_id) {
                        if ( 'category' == $model->taxonomy)
                                return $this->redirect(['cindex']);
                        else
                                return $this->redirect(['index']);
                }
                else {
                        return $this->redirect(['page']);
                }
        }

        /**
         * Delete all of selected Post models.
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
                
                if ($model->term_taxonomy_id) {
                        if ( 'category' == $model->taxonomy)
                                return $this->redirect(['cindex']);
                        else
                                return $this->redirect(['index']);
                }
                else {
                        return $this->redirect(['page']);
                }
        }

        /**
         * Finds the Post model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param string $id
         * @return Post the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Post::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        /**
         * Update the sequence in the group models.
         * @param bigint $group_id the group_id of the model
         * @param integer $sequence the sequence of the model
         * @return integer number of rows affected by command
         */
        protected function updateOrder($group_id, $sequence)
        {
            $sql = sprintf("update %s set sequence=sequence+1 where group_id=%s && sequence>%s", Post::tableName(), $group_id, $sequence);
            $command = Yii::$app->db->createCommand($sql);
            return $command->execute();
        }

        /**
         * Get Max id in the total models.
         * @return bigint max id
         */
        protected function getMaxId()
        {
            $sql = sprintf("select MAX(po_id) as max_id from %s", Post::tableName());
            $command = Yii::$app->db->createCommand($sql);
            $row = $command->queryOne();
            return $row[ 'max_id' ];
        }  

        /**
         * Increase Hit Count.
         */
        protected function increaseHitCount($po_id)
        {
            $sql = sprintf("update %s set hit_count = hit_count+1 where po_id=%s", Post::tableName(), $po_id);
            $command = Yii::$app->db->createCommand($sql);
            $row = $command->query();
        }
}
