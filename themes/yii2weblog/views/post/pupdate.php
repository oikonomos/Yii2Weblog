<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsPost */

$this->title = Yii::t('app', 'Update Page') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['post/page']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['page_view', 'id' => $model->po_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Page');
?>
<div class="post-update">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_pform', [
        'model' => $model,
    ]) ?>

</div>
