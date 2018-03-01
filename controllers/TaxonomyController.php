<?php

namespace app\controllers;

use Yii;
use app\models\Term;
use app\models\TermTaxonomy;
use app\models\TermTaxonomySearch;
use app\components\MyController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Query;

/**
 * TaxonomyController implements the CRUD actions for TermTaxonomy model.
 */
class TaxonomyController extends MyController
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
         * Lists all TermTaxonomy models.
         * @return mixed
         */
        public function actionIndex()
        {
                $searchModel = new TermTaxonomySearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Lists all TermTaxonomy models.
         * @return mixed
         */
        public function actionCindex()
        {
                $searchModel = new TermTaxonomySearch();
                $dataProvider = $searchModel->searchByCategory(Yii::$app->request->queryParams);

                return $this->render('cindex', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
        }

        /**
         * Displays a single TermTaxonomy model.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id)
        {
                $model = $this->findModel($id);
                $term = Term::findOne($model->term_id);
                $model->name = $term->name;
                $model->slug = $term->slug;

                return $this->render('view', [
                        'model' => $model,
                ]);
        }

        /**
         * Creates a new TermTaxonomy model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
                $term = new Term();
                $termTaxonomy = new TermTaxonomy();

                if ( Yii::$app->request->isPost ) {
                        $term->attributes = Yii::$app->request->post("Term");
                        // Begin transaction
                        $transaction = Yii::$app->db->beginTransaction();
                        
                        if ( $term->save() ) {
                                $termTaxonomy->attributes = Yii::$app->request->post("TermTaxonomy");
                                try {
                                        $termTaxonomy->term_id = $term->term_id;
                                        $termTaxonomy->term_taxonomy_id = $this->getMaxId() + 1;
                                        $termTaxonomy->count = 0;
                                        if ($termTaxonomy->parent) { 
                                                $parentTaxonomy = TermTaxonomy::findOne($termTaxonomy->parent);
                                                $termTaxonomy->family_id = $parentTaxonomy->family_id;
                                                $termTaxonomy->level = $parentTaxonomy->level + 1;
                                                $termTaxonomy->sequence = $parentTaxonomy->sequence + 1;
                                                $this->updateOrder($parentTaxonomy->family_id, $parentTaxonomy->sequence);
                                        }
                                        else {
                                                $termTaxonomy->parent = 0;
                                                $termTaxonomy->family_id = $termTaxonomy->term_taxonomy_id;
                                                $termTaxonomy->level = 0;
                                                $termTaxonomy->sequence = 0;
                                        }

                                        if ($termTaxonomy->save()) {
                                                // Commit
                                                $transaction->commit();
                                                return $this->redirect(['view', 'id' => $termTaxonomy->term_taxonomy_id]);
                                        }
                                        else {// Rollback
                                                //var_dump($termTaxonomy);
                                                $transaction->rollback();
                                                exit;
                                        }
                                }
                                catch (Exception $ex) {
                                        // Rollback
                                        $transaction->rollback();
                                        echo $ex->getMessage();
                                }
                        }
                }
                else {
                        return $this->render('create', [
                                'termTaxonomy' => $termTaxonomy,
                                'term' => $term,
                        ]);
                }
        }

        /**
         * Updates an existing TermTaxonomy model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
                $termTaxonomy = $this->findModel($id);
                $term = Term::findOne($termTaxonomy->term_id);
                //$term->scenario = "update";

                if ( Yii::$app->request->isPost ) {
                        $term->attributes = Yii::$app->request->post("Term");
                        // Begin transaction
                        $transaction = Yii::$app->db->beginTransaction();
                        
                        if ( $term->save() ) {
                                $termTaxonomy->attributes = Yii::$app->request->post("TermTaxonomy");
                                try
                                {
                                        $termTaxonomy->term_id = $term->term_id;
                                        if ($termTaxonomy->parent != $_POST['prev_parent'])
                                        {                                  
                                                if( $termTaxonomy->parent ) {
                                                        $parentTaxonomy = TermTaxonomy::findOne($termTaxonomy->parent);
                                                        $termTaxonomy->family_id = $parentTaxonomy->family_id;
                                                        $termTaxonomy->level = $parentTaxonomy->level + 1;
                                                        $termTaxonomy->sequence = $parentTaxonomy->sequence + 1;
                                                        $this->updateOrder($parentTaxonomy->family_id, $parentTaxonomy->sequence);
                                                } 
                                                else {
                                                        $termTaxonomy->parent = 0;
                                                        $termTaxonomy->family_id = $termTaxonomy->term_taxonomy_id;
                                                        $termTaxonomy->level = 0;
                                                        $termTaxonomy->sequence = 0;
                                                }
                                        }
                                        if ($termTaxonomy->save()) {
                                                // Commit
                                                $transaction->commit();
                                                $this->redirect(['view','id'=>$termTaxonomy->term_taxonomy_id]);
                                        }
                                        else {
                                                $transaction->rollback();
                                        }
                                }
                                catch (Exception $ex) {
                                        // Rollback
                                        $transaction->rollback();
                                        echo $ex->getMessage();
                                }
                        }
                } else {
                        return $this->render('update', [
                                'termTaxonomy' => $termTaxonomy,
                                'term' => $term,
                        ]);
                }
        }

        /**
         * Deletes an existing TermTaxonomy model.
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
         * Delete all of selected Post models.
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
         * Finds the TermTaxonomy model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return TermTaxonomy the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
                if (($model = TermTaxonomy::findOne($id)) !== null) {
                        return $model;
                } else {
                        throw new NotFoundHttpException('The requested page does not exist.');
                }
        }
        
        /**
         * @설명 : 같은 부모를 갖는 모든 분류 항목들을 데이터베이스로부터 가져온다.
         */ 
        public function actionCategory()
        {
                if (isset($_POST['parent'])) {
                        if($_POST['parent']) {
                                $query = new Query;
                                $query->select('term_taxonomy.term_taxonomy_id, b.name')
                                        ->from('term_taxonomy')
                                        ->leftJoin('term b', 'term_taxonomy.term_id=b.term_id');
                                $query->andFilterWhere([
                                        'term_taxonomy.parent' => $_POST['parent']
                                ]);
                                $query->andFilterCompare('term_taxonomy.term_taxonomy_id', 0, '<>');

                                $rows = $query->all();
                                if (is_array($rows))
                                        print_r(json_encode($rows));
                        }
                }
                else {
                        throw new HttpException(400,'Invalid request. Please do not repeat this request again.');
                }

                Yii::$app->end();
        }

        /**
         * Update the sequence in the group models.
         * @param bigint $family_id the family_id of the model
         * @param integer $sequence the sequence of the model
         * @return integer number of rows affected by command
         */
        protected function updateOrder($family_id, $sequence)
        {
                $sql = sprintf("update %s set sequence=sequence+1 where family_id=%d && sequence>%d", TermTaxonomy::tableName(), $family_id, $sequence);
                $command = Yii::$app->db->createCommand($sql);
                return $command->execute();
        }

        /**
         * Get Max id in the total models.
         * @return bigint max id
         */
        protected function getMaxId()
        {
                $sql = sprintf("select MAX(term_taxonomy_id) as max_id from %s", TermTaxonomy::tableName());
                $command = Yii::$app->db->createCommand($sql);
                $row = $command->queryOne();
                return $row[ 'max_id' ];
        }

        /**
         * Reorder children of terms by term name that have the same parent.
         * @param integer $parent
         * @param integer $family_id
         * @param string $name term name
         */
        protected function getSequence ($parent, $family_id, $name, $sequence) 
        {
                //echo $parent . '||' . $family_id . '||' . $name; exit;
                if ( !$parent || !$family_id || !$name )
                        return 0;
                $taxonomy = new TermTaxonomy();
                $children = $taxonomy->find(['family_id'=>$family_id, 'parent'=>$parent])
                        ->joinWith(['term b'], true, 'LEFT JOIN')
                        ->where(['family_id'=>$family_id, 'parent'=>$parent])
                        ->orderBy(['sequence'=>SORT_ASC])
                        ->select('b.name, sequence')
                        ->createCommand()
                        ->queryAll();

                if ( !empty($children) && is_array($children) ) {
                        $newArr = array();
                        foreach ($children as $child) {
                            $newArr[$child['name']] = $child['sequence'];
                        }
                        $newArr[$name] = $sequence;
                        ksort($newArr);

                        $keys = array_keys($newArr);
                        $idx = array_search($name, $keys);

                        $len = count($keys);

                        // If position will be first child
                        if ($idx == 0) {
                                return $newArr[$keys[$idx]] + 1;
                        }
                        // If position will be last child
                        elseif ($idx == $len - 1) {
                                $sql = sprintf("SELECT MAX(sequence) as max_seq FROM %s WHERE family_id=%d", TermTaxonomy::tableName(), $family_id);
                                $command = Yii::$app->db->createCommand($sql);
                                $row = $command->queryOne();
                                //print_r($row); exit;
                                return $row['max_seq'] + 1;
                        }
                        // If position will be between first and last
                        else {
                                //print_r($newArr); echo $newArr[$keys[$idx + 1]]; exit;
                                return $newArr[$keys[$idx + 1]];
                        }
                }
                else {
                    return $sequence + 1;
                }
        }
}
