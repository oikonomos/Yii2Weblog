<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */

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

$this->title = $taxonomy->name;
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
                                <?=Yii::t('app', 'Hit Count')?> : <span class="hit_count"><?php echo $model->hit_count?></span>
                        </div>
                </div>
            
                <?php if ($model->attachment): ?>
                <div class="view-files">
                        <?=$model->transformAttachmentToTags($model->attachment);?>
                </div>
                <?php endif; ?>
        
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
                <?= Html::a('List', ['list', 'tt_id'=>$model->term_taxonomy_id], ['class' => 'FR btn-list']) ?>
                <?= Html::a('Create Post', ['create', 'tt_id'=>$model->term_taxonomy_id], ['class' => 'FR btn-write']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->po_id, 'tt_id'=>$model->term_taxonomy_id , 'pos'=>'web'], [
                    'class' => 'FL btn-delete',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you delete this post? If you delete it, it can not be restored.'),
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Update Post', ['update', 'id' => $model->po_id, 'tt_id'=>$model->term_taxonomy_id], ['class' => 'FL btn-write']) ?>
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

<!-- Original Photo View -->
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
