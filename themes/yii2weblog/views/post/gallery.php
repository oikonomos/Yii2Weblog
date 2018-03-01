<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\GalleryView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

use app\models\Term;
use app\models\TermTaxonomy;
use nirvana\prettyphoto\PrettyPhoto;

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
                'id' => 'gallerylist-form',
        ]); ?>

        <?= GalleryView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '<div id="list-summary"><span>전체 {totalCount}</span></div>',
                'layout' =>  '<ul class="gallerylist">{items}</ul>{pager}',
                'showOnEmpty' => false,
                'emptyText' => Yii::t('app', 'No posts found.'),
                'emptyTextOptions' => ['class' => 'empty', 'colspan' => 5 ],
                'summaryOptions' => [ 'class' => 'gallery-summary' ],
                'itemOptions' => [ 'tag' => false ],
                'id' => 'gallery-list',
                //'viewParams' => [ 'qtx' => $stx ],
                'options' => [ 'class' => 'gallerylist-wrap' ],
                'itemView' => 'galleryitem'
        ]); ?>

        <?php ActiveForm::end(); ?>

        <div class="list-buttons">
                <?= Html::a('글쓰기', ['create'], ['class' => 'FR btn-write', 'role'=>'button']) ?>
        </div>

        <?php $form2 = ActiveForm::begin([
                'id' => 'search',
                'method' => 'post',
                'action' => Url::to(['post/gallery', 'tt_id' => $_GET['tt_id']]),
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

<!-- 원본 사진 보기 -->
<?php 
PrettyPhoto::widget([
    'target' => "a[rel^='prettyPhoto']",
    'pluginOptions' => [
        'opacity' => 0.60,
        'theme' => PrettyPhoto::THEME_DARK_SQUARE,
        'social_tools' => false,
        'autoplay_slideshow' => true,
        'modal' => true
    ],
]);
?>

