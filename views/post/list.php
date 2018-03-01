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

$this->title = '글목록';
$this->params['breadcrumbs'][] = $this->title;

$searchOptions = [
    ['key' =>'', 'value'=>'선택' ],
    ['key' =>'title', 'value'=>'제목' ],
    ['key' =>'content', 'value'=>'내용' ],
    ['key' =>'writer', 'value'=>'작성자' ],
    ['key' =>'email', 'value'=>'이메일' ],
    ['key' =>'created_at', 'value'=>'작성일' ],
];

if ( isset($_GET[ 'tt_id']) && $_GET[ 'tt_id'] ) {
    $taxonomy = TermTaxonomy::findOne( $_GET[ 'tt_id'] );
    $taxonomy->setNameNSlug();
}
else
{
    throw new yii\web\NotFoundHttpException('카테고리가 없습니다.');
}

$headerColor = $taxonomy->getColor($taxonomy->color2)->value;
$headerLineColor = $taxonomy->getColor($taxonomy->color)->value;
$headerFontColor = $taxonomy->getColor($taxonomy->font)->value;

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

    <div id="list-title" class="list-title"><?php echo $taxonomy->name ?></div>
    
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
            'emptyText' => '작성된 글이 없습니다.',
            'emptyTextOptions' => ['class' => 'empty', 'colspan' => 5 ],
            'summaryOptions' => [ 'class' => 'list-summary' ],
            'itemOptions' => [ 'tag' => false ],
            'id' => 'post-list',
            'itemView' => 'listitem'
        ]); ?>

    <?php ActiveForm::end(); ?>

    <div class="list-buttons">
        <?= Html::a('글쓰기', ['create'], ['class' => 'FR btn-write']) ?>
    </div>

    <?php $form2 = ActiveForm::begin([
        'id' => 'search',
        'method' => 'post',
        'action' => Url::to(['post/list', 'tt_id' => $_GET['tt_id']]),
        'options' => [ 'name' => 'search' ]
    ]); ?>
        <?php echo Html::hiddenInput('tt_id', $_GET['tt_id']) ?>
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
                    <?= Html::button('검색', ['id'=>'btn-search', 'class'=>'btn-search']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- content::end -->

<?php
$this->registerJs(
"
$('#btn-search').click(function(e){
    e.stopPropagation();
    
    var sfld = $('#searchform-sfld');
    var stx = $('#searchform-stx');
    
    if (!sfld.val()) {
        alert('검색필드를 선택하세요.');
        sfld.focus();
        return false;
    }
        
    if (!stx.val()) {
        alert('검색어를 입력하세요.');
        stx.focus();
        return false;
    }
    
    $('#search').submit();
});    
");
?>


