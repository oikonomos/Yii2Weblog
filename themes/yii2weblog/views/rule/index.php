<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Auth Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-index">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="listbutton-wrap">
        <?= Html::a(Yii::t('app', 'Create Auth Rule'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete Selected Auth Rules'), 'javascript:void(0);', ['id'=>'delete-items', 'class' => 'btn btn-danger']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

            'name',
            'data:ntext',
            [
                'attribute' => 'created_at',
                'value' => function($data){
                    $date = substr(date('Y-m-d', $data->created_at), 0, 10);
                    return $date;
                },
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_date',
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions' => [
                        'autoclose' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                    ],
                ]),
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($data){
                    $date = substr(date('Y-m-d', $data->updated_at), 0, 10);
                    return $date;
                },
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_date',
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions' => [
                        'autoclose' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                    ],
                ]),
            ],

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
        location.href = '%s?_csrf=' + '%s' + '&ids=' + ids;
    }    
});
})(jQuery);
", Yii::t('app', 'Select items you would delete.'), Yii::t('app', 'If you would delete, you do not recover them. Do you delete all selected items?'), Url::toRoute(['rule/deleteall']), Yii::$app->request->csrfToken ) );
?>