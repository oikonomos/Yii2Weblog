<?php

/* 
 * @WebPageName list_item,php
 * @author Suhk, Sangbom 
 */

/* @var $model yii\db\ActiveRecord */

use yii\helpers\Html;

$thumb = $model->getGalleryThumb();
$titCnt = mb_strlen($model->title);
if ($titCnt > 20) {
        $title = mb_substr($model->title, 0, 20) . '...';
}
else {
        $title = $model->title;
}
?>  
<li class="gallery-item">
        <div class="gi-thumb-frame"><a href="<?=$thumb['imgUrl']?>" rel="prettyPhoto[gallery1]" title="<?=$model->title?>"><img src="<?=$thumb['thumb']?>" alt="<?=$thumb['filename']?>" /></a></div>
        <h2 class="gi-title">
                <?php echo Html::a($title, ['gview', 'id' => $model->po_id, 'tt_id' => $model->term_taxonomy_id]); ?>
        </h2>
</li>

