<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modelsPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Delete Selected Auth Items'), 'javascript:void(0);', ['id'=>'delete-items', 'class' => 'btn btn-danger']) ?>
    </p>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],

            //'po_id',
            'author_id',
            //'parent',
            //'password',
            'writer',
            'title',
            // 'content:ntext',
            // 'excerpt:ntext',
            'email:email',
            // 'homepage',
            [
                'attribute' => 'created_at',
                'value' => function($data){
                    return substr($data->created_at, 0, 10);
                },
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions' => [
                        'autoclose' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                    ],
                ]),
            ],
            // 'updated_at',
            'term_taxonomy_id',
            'status',
            // 'tags:ntext',
            // 'post_type',
            // 'group_id',
            // 'level',
            // 'sequence',
            'hit_count',
            'comment_status',
            //'comment_count',

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
", Yii::t('app', 'Select items you would delete.'), Yii::t('app', 'If you would delete, you do not recover them. Do you delete all selected items?'), Url::toRoute(['post/deleteall']), Yii::$app->request->csrfToken ) );
?>