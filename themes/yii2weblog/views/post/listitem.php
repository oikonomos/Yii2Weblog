<?php

/* 
 * @WebPageName list_item,php
 * @author Suhk, Sangbom 
 */

/* @var $model yii\db\ActiveRecord */

use yii\helpers\Html;


?>  
<tr class="list-row">
    <td class="number">
        <?=($index + 1)?>
    </td>
<!--    <td class="checkbox">
        <?=Html::checkbox( 'selection[]', '', [ 'class' => 'checkbox' ] )?>
    </td>-->
    <td class="title">
        <?php echo Html::a($model->title, ['lview', 'id' => $model->po_id, 'tt_id' => $model->term_taxonomy_id]); ?>
    </td>
    <td class="writer">
        <?=$model->writer;?>
    </td>
    <td class="date">
        <?=substr($model->created_at, 0, 10);?>
    </td>
    <td class="counter">
        <?=$model->hit_count;?>
    </td>
</tr>

