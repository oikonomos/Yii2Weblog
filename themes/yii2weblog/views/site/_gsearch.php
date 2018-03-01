<?php

/* 
 * @WebPageName list_item,php
 * @author Suhk, Sangbom 
 */

/* @var $model yii\db\ActiveRecord */

use yii\helpers\Html;
switch ($model->post_type) {
        case 'post':
                $link = '/post/lview';
                break;
        case 'gallery':
                $link = '/post/gview';
                break;
        case 'page':
                $link = '/post/pview';
                break;
        default :
                $link = '/post/lview';
                break;
}
?>  
<div class="sr-row">    
    <span class="sr-title"><?php echo Html::a(preg_replace('/'.$qtx.'/', '<span class="highlightd-word">'.$qtx.'</span>', $model->title), [$link, 'id' => $model->po_id, 'tt_id' => $model->term_taxonomy_id]); ?></span>
    <div class="date"><?=Yii::t('app', 'Writer')?>: <?=$model->writer;?>, <?=Yii::t('app', 'Written Date')?>: <?=$model->created_at;?></div>
    <p class="sr-excerpt"><?= preg_replace('/'.$qtx.'/', '<span class="highlightd-word">'.$qtx.'</span>', strip_tags($model->excerpt));?></p>
</div>

