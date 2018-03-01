<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $taxonomy app\models\TermTaxonomy */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\TermTaxonomy;

use nirvana\prettyphoto\PrettyPhoto;
use app\components\widgets\comment\Comment;

$headerColor = trim($taxonomy->color2, '#');
$headerLineColor = trim($taxonomy->color, '#');
$headerFontColor = trim($taxonomy->font, '#');

$params = array();

$this->title = $taxonomy->name . ' 글내용보기';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- content::start -->
<div id="content" class="content">

        <div id="cont-title" class="cont-title"><?php echo $taxonomy->name ?></div>

        <div class="view-wrap" style="border-bottom:2px solid #<?php echo $headerLineColor?>;">
        
                <div class="view-titlewrap" style="background-color:#<?php echo $headerColor?>;border-top:2px solid #<?php echo $headerLineColor?>;border-bottom:2px solid #<?php echo $headerLineColor?>;color:#<?php echo $headerFontColor?>">
                        <div class="view-title"><?php echo $model->title ?></div>
                        <div class="article-info">
                                <i class="fa fa-user"></i>&nbsp; 
                                <span class="ai-name"><?php echo $model->writer?></span> &nbsp;
                                <span class="ai-date"><?php echo $model->created_at?></span> &nbsp;
                                조회수 : <span class="hit_count"><?php echo $model->hit_count?></span>
                        </div>
                </div>
            
                <?php if ($model->attachment): ?>
                <div class="view-files">
                        <?=$model->transformAttachmentToTags($model->attachment);?>
                </div>
                <?php endif; ?>
                
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>
        
                <div class="view-content">
                    <?php echo nl2br($model->content) ?>
                </div>
                
                <div class="prev-next-container">
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

<?php
$media = $model->getFirstAttachment($model->attachment);
$image = getimagesize($media->file_path . DIRECTORY_SEPARATOR . $media->filename);
$this->registerMetaTag( [ 'name' => 'fb:app_id', 'content' => '141827599817914' ] );
$this->registerMetaTag( [ 'name' => 'og:title', 'content' => $model->title ] );
$this->registerMetaTag( [ 'name' => 'og:type', 'content' => 'article' ] );
$this->registerMetaTag( [ 'name' => 'og:url', 'content' => Yii::$app->params['defaultUrl'] . \yii\helpers\Url::to([ 'post/gview', 'id' => $model->po_id, 'tt_id' => $model->term_taxonomy_id ]) ] );
$this->registerMetaTag( [ 'name' => 'og:image', 'content' => $media->file_url ] );
$this->registerMetaTag( [ 'name' => 'og:image:width', 'content' => $image[0] ] );
$this->registerMetaTag( [ 'name' => 'og:image:height', 'content' => $image[1] ] );
$this->registerMetaTag( [ 'name' => 'og:image:type', 'content' => $media->file_mime_type ] );
$this->registerMetaTag( [ 'name' => 'og:description', 'content' => strip_tags($model->excerpt) ] );
$this->registerMetaTag( [ 'name' => 'og:locale', 'content' => 'ko_KR' ] );
$this->registerJsFile( '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a629deb560f7e07', [
    'position'=> \yii\web\View::POS_END,
    'depends'=>[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ]
]);
?>
