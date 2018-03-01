<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\MyListView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

use app\models\Term;
use app\models\TermTaxonomy;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $taxonomy->name . ' 글목록';
$this->params['breadcrumbs'][] = $this->title;

$searchOptions = [
    ['key' =>'', 'value'=>'선택' ],
    ['key' =>'title', 'value'=>'제목' ],
    ['key' =>'content', 'value'=>'내용' ],
    ['key' =>'writer', 'value'=>'작성자' ],
    ['key' =>'email', 'value'=>'이메일' ],
    ['key' =>'created_at', 'value'=>'작성일' ],
];

$headerColor = trim($taxonomy->color2, '#');
$headerLineColor = trim($taxonomy->color, '#');
$headerFontColor = trim($taxonomy->font, '#');

$params = [
    'number' => '번호',
    //'checkbox' => Html::checkbox( 'checkall', false, [ 'class'=>'checkbox' ] ),
    'title' => '제목',
    'writer' => '작성자',
    'date' => '작성일',
    'counter' => '조회수',
]
?>

<!-- content::start -->
<div id="content" class="content">

    <div id="cont-title" class="cont-title"><?php echo $taxonomy->name ?></div>
    
    <?php $form = ActiveForm::begin([
        'id' => 'list-form',
    ]); ?>

        <?= MyListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '<div id="list-summary"><span>전체 {totalCount}</span></div>',
            'listBeginTag' => '<table class="list-table">',
            'listEndTag' => '</table>',
            'listHeaderColor' => $headerColor,
            'listHeaderLineColor' => $headerLineColor,
            'listHeaderFontColor' => $headerFontColor,
            'layout' =>  "{summary}\n{listBeginTag}\n{header}\n{items}\n{listEndTag}\n{pager}",
            'params' => $params,
            'showOnEmpty' => false,
            'emptyText' => Yii::t('app', 'There is no post.'),
            'emptyTextOptions' => ['class' => 'empty', 'colspan' => 5 ],
            'summaryOptions' => [ 'class' => 'list-summary' ],
            'itemOptions' => [ 'tag' => false ],
            'id' => 'post-list',
            'itemView' => 'listitem'
        ]); ?>

    <?php ActiveForm::end(); ?>

    <div class="list-buttons">
        <?= Html::a('글쓰기', ['create'], ['class' => 'FR btn-write', 'role'=>'button']) ?>
    </div>

    <?php $form2 = ActiveForm::begin([
        'id' => 'listsearch',
        'method' => 'post',
        'action' => Url::to(['post/list', 'tt_id' => $taxonomy->term_taxonomy_id]),
        'options' => [ 'name' => 'search' ]
    ]); ?>
        <div class="searchform-wrap">
            <div class="searchform">
                    <?php echo $form2->field($searchForm, 'sfld', ['template'=>'{input}', 'options'=>['class'=>'searchfield-wrap']])->dropDownList(
                            ArrayHelper::map(
                                $searchOptions,
                                'key',
                                'value'
                            ),
                            [
                                'class' => 'searchfield'
                            ]
                    ); ?>
                    <?php echo $form2->field($searchForm, 'stx', ['template'=>'{input}', 'options'=>['class'=>'searchtext-wrap']])->textInput(['class'=>'searchtext']); ?>
                    <?= Html::button(Yii::t('app', 'Search'), ['id'=>'btn-listsearch', 'class'=>'btn-search']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- content::end -->

<?php
$this->registerJs( sprintf("
$('#btn-listsearch').click(function(e){
    e.stopPropagation();
    var a = $('#searchform-sfld');
    var b = $('#searchform-stx');    
    if (!a.val()) { alert('%s'); a.focus(); return false; }
    if (!b.val()) { alert('%s'); b.focus(); return false; }
    $('#listsearch').submit();
    console.log($('#listsearch').html());
}); ", Yii::t('app', 'Select search field.'), Yii::t('app', 'Enter search text.') ));
?>


