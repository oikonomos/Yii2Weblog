<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $id string */
/* @var $width string */
/* @var $height string */

$inlineStyle = "";
$inlineStyle .= ($width) ? "width:".$width."px;" : "";
$inlineStyle .= ($dim_y) ? "top:".$dim_y."px;" : "";
$inlineStyle .= ($dim_x) ? "left:".$dim_x."px;" : "";
$inlineStyle .= ($po_center=='yes') ? "margin-left:50%;" : "";
?>
<div id="popupwrap" class="popupwrap" style="<?=$inlineStyle?>">
        <div class="popup-content" style="width:<?=$width?>px;height:<?=$height?>px;">
                <?=trim($content)?>
        </div>
        <div class="popup-bottom">
                <?= Html::hiddenInput('popupid', $popupid, ['id' => 'popupid']).PHP_EOL?>
                <input type="checkbox" name="block_popup" id="block-popup" class="checkbox" value="1" style="float:left;" /> <span style="display:inline-block;position:relative;margin:0 0 0 4px;"><?=Yii::t('app', 'I will not view this popup, today.')?></span>
                <a href="javascript:void(0);" id="btn-pclose"><img src="/images/popup_close.gif" alt="" style="float:right;" /></a>
        </div>
</div>