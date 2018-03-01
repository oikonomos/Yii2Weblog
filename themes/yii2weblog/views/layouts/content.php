<?php
use yii\widgets\Breadcrumbs;
?>
<div id="contents" class="container">
        <?php if( isset($this->params['breadcrumbs']) ): ?>
        <div class="breadcrum-wrap">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
        </div>
        <?php endif; ?>
        <?= $content ?>
</div><!--#content-->
