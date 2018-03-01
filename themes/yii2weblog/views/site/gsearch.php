<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use app\components\widgets\search\Search;
use app\components\widgets\SearchView;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search Results');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="post-gsearch">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->
        
    <?php echo Search::widget( [ 'view'=>'search2', 'id'=>'searchform2', 'gstx'=>$gstx, 'inputId'=>'gstx3', 'buttonId'=>'btn-search3', 'total' => $dataProvider->totalCount ] ); ?>
    
    <?= SearchView::widget([
            'dataProvider' => $dataProvider,
            //'summary' => '<div id="list-summary"><span>전체 {totalCount}</span></div>',
            'layout' =>  '<div class="resultlist">{items}</div>{pager}',
            'showOnEmpty' => false,
            'emptyText' => Yii::t('app', 'No posts found.'),
            'emptyTextOptions' => ['class' => 'empty', 'colspan' => 5 ],
            'summaryOptions' => [ 'class' => 'list-summary' ],
            'itemOptions' => [ 'tag' => false ],
            'id' => 'result-list',
            'viewParams' => [ 'qtx' => $gstx ],
            'options' => [ 'class' => 'resultlist-wrap' ],
            'itemView' => '_gsearch'
    ]); ?>
</div>
