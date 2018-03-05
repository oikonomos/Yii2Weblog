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

$this->title = $taxonomy->name;
$this->params['breadcrumbs'][] = $this->title;

$searchOptions = [
    ['key' =>'', 'value'=>Yii::t('app', 'Select') ],
    ['key' =>'title', 'value'=>Yii::t('app', 'Title') ],
    ['key' =>'content', 'value'=>Yii::t('app', 'Content') ],
    ['key' =>'writer', 'value'=>Yii::t('app', 'Writer') ],
    ['key' =>'email', 'value'=>Yii::t('app', 'Email') ],
    ['key' =>'created_at', 'value'=>Yii::t('app', 'Create At') ],
];

$headerColor = trim($taxonomy->color2, '#');
$headerLineColor = trim($taxonomy->color, '#');
$headerFontColor = trim($taxonomy->font, '#');

$params = [
    'number' => Yii::t('app', 'No'),
    //'checkbox' => Html::checkbox( 'checkall', false, [ 'class'=>'checkbox' ] ),
    'title' => Yii::t('app', 'Title'),
    'writer' => Yii::t('app', 'Writer'),
    'date' => Yii::t('app', 'Created At'),
    'counter' => Yii::t('app', 'Hit'),
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
                <?= Html::a('Create Post', ['create'], ['class' => 'FR btn-write', 'role'=>'button']) ?>
        </div>

        <?php $form2 = ActiveForm::begin([
                'id' => 'listsearch',
                'method' => 'post',
                'action' => Url::to(['post/gallery', 'tt_id' => $taxonomy->term_taxonomy_id]),
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

