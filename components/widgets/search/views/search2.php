<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $method string */
/* @var $id string */
/* @var $gstx string */
/* @var $inputId string */
/* @var $buttonId string */
/* @var $total integer */
/* @var $htmlOptions array */
?>
<!-- Global Search Widget Begin -->
<div class="searchresult-wrap">

        <div class="searchscope">
                <label>검색범위</label>
                <input type="checkbox" name="title" value="1" checked /> <span class="sr-text">제목</span>
                <input type="checkbox" name="content" value="1" checked /> <span class="sr-text">내용</span>
                <input type="checkbox" name="tags" value="1" checked /> <span class="sr-text">태그</span>
        </div>
        <div class="searchform-wrap">
                <label>검색어</label>
                <div class="searchform">
                <?php
                        echo Html::beginForm(['/site/gsearch'], ($method)?$method:'get', [ 'id'=>$id ]) . PHP_EOL;
                        echo Html::hiddenInput('mode', 'omnisearch') . PHP_EOL;
                        echo Html::input('text', 'gstx', ($gstx)?$gstx:'', [ 'id' => $inputId, 'placeholder' => Yii::t('app', 'Search Text') ]) . PHP_EOL;
                        echo Html::button('<i class="fa fa-search"></i>', [ 'id' => $buttonId, 'class' => $buttonId, 'type' => 'submit' ]) . PHP_EOL;
                        echo Html::endForm() . PHP_EOL;
                ?>
                </div>
        </div>
        <div class="searchresult">
                <span class="sr-title">검색 결과 <?=$total?>건</span>
        </div>
        
</div>
<!-- Global Search Widget End -->