<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsWebsightLogCounterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Websight Log Counters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="websight-log-counter-index">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a(Yii::t('app', 'Create Websight Log Counter'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idx',
            'yyyy',
            'mm',
            'dd',
            'h0',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'h7',
            'h8',
            'h9',
            'h10',
            'h11',
            'h12',
            'h13',
            'h14',
            'h15',
            'h16',
            'h17',
            'h18',
            'h19',
            'h20',
            'h21',
            'h22',
            'h23',
            'week',
            'hit',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
