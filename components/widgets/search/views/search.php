<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $method string */
/* @var $id string */
/* @var $gstx string */
/* @var $inputId string */
/* @var $buttonId string */
/* @var $htmlOptions array */
?>
<!-- Global Search Widget Begin -->
<div class="gsearchform-wrap">
        <div class="gsearchform">
                <?php
                        echo Html::beginForm(['/site/gsearch'], ($method)?$method:'get', [ 'id'=>$id ]) . PHP_EOL;
                        echo Html::hiddenInput('mode', 'omnisearch') . PHP_EOL;
                        echo Html::input('text', 'gstx', ($gstx)?$gstx:'', [ 'id' => $inputId, 'placeholder' => Yii::t('app', 'Search Text') ]) . PHP_EOL;
                        echo Html::button('<i class="fa fa-search"></i>', [ 'id' => $buttonId, 'class' => $buttonId, 'type' => 'submit' ]) . PHP_EOL;
                        echo Html::endForm() . PHP_EOL;
                ?>
        </div>
</div>
<!-- Global Search Widget End -->