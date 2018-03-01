<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\TermTaxonomy;

use nirvana\prettyphoto\PrettyPhoto;
use app\components\widgets\comment\Comment;

if ( isset($_GET[ 'tt_id']) && $_GET[ 'tt_id'] ) {
    $taxonomy = TermTaxonomy::findOne( $_GET[ 'tt_id'] );
    $taxonomy->setNameNName();
}
else
{
    throw new yii\web\NotFoundHttpException('카테고리가 없습니다.');
}

$headerColor = $taxonomy->getColor($taxonomy->color2)->value;
$headerLineColor = $taxonomy->getColor($taxonomy->color)->value;
$headerFontColor = $taxonomy->getColor($taxonomy->font)->value;

$params = array();
?>

<!-- content::start -->
<div id="content" class="content">

    <div id="list-title" class="list-title"><?php echo $taxonomy->name ?></div>
    
    <div class="view-wrap" style="border-bottom:2px solid #<?php echo $headerLineColor?>;">
        
        <div class="view-title-wrap" style="background-color:#<?php echo $headerColor?>;border-top:2px solid #<?php echo $headerLineColor?>;border-bottom:2px solid #<?php echo $headerLineColor?>;color:#<?php echo $headerFontColor?>">
            <div class="view-title"><?php echo $model->title ?></div>
            <div class="article-info">
                <i class="fa fa-user"></i>&nbsp; 
                <span class="ai-name"><?php echo $model->writer?></span> &nbsp;
                <span class="ai-date"><?php echo $model->created_at?></span> &nbsp;
                조회수 : <span class="hit_count"><?php echo $model->hit_count?></span>
            </div>
        </div>
        
        <div class="view-content">
            <?php echo nl2br($model->content) ?>
        </div>
        
        <div class="prev-next-wrap">
            <?php if ($model->retrievePrevousPostId($params)): ?>
            <?php endif; ?>
            <?php if ($model->retrieveNextPostId($params)): ?>
            <?php endif; ?>
        </div>
    
    </div>

    <div class="view-button-group">
        <?= Html::a('목록', ['list', 'tt_id'=>$model->term_taxonomy_id], ['class' => 'FR btn-list']) ?>
        <?= Html::a('글쓰기', ['create', 'tt_id'=>$model->term_taxonomy_id], ['class' => 'FR btn-write']) ?>
        <?= Html::a('삭제', ['delete', 'id' => $model->po_id, 'tt_id'=>$model->term_taxonomy_id , 'pos'=>'web'], [
            'class' => 'FL btn-delete',
            'data' => [
                'confirm' => '정말로 삭제하시겠습니까? 삭제하면 다시 복원할 수 없습니다.',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('수정', ['update', 'id' => $model->po_id, 'tt_id'=>$model->term_taxonomy_id], ['class' => 'FL btn-write']) ?>
    </div>  
     
    <?php
        echo Comment::widget([
            'comments' => $model->getComments()->all(),
            'postId' => $model->po_id,
            'authorId' => Yii::$app->user->id,
        ]);
    ?>
    
</div>
<!-- content::end -->

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
