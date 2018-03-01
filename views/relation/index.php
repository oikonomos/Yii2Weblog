<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsAuthItemChildSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Auth Item Children');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Auth Item Child'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete Selected Auth Item Children'), 'javascript:void(0);', ['id'=>'delete-items', 'class' => 'btn btn-danger']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

            'parent',
            'child',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>


<?php
$this->registerJs( sprintf("
(function($) { 
$( '#delete-items' ).click(function(e){
    e.stopPropagation();
    var selection = $(\"input[name='selection[]']\");
    var ids = null;
    for ( var i=0; i<selection.length; i++ )
    {
        if ( selection.eq(i).prop('checked') )
        {
            if ( !ids ) ids = selection.eq(i).val();
            else ids = ids + '|' + selection.eq(i).val();
        }
    }
    if ( !ids )
    {
        alert('%s');
        return false;
    }
    
    if ( ids && confirm( '%s' ) )
    {
        location.href = '%s&_csrf=' + '%s' + '&ids=' + ids;
    }
});
})(jQuery);
", Yii::t('app', 'Select items you would delete.'), Yii::t('app', 'If you would delete, you do not recover them. Do you delete all selected items?'), Url::toRoute(['relation/deleteall']), Yii::$app->request->csrfToken ) );
?>