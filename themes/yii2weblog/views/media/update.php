<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsMedia */

$this->title = Yii::t('app', 'Update Media: ', [
    'modelClass' => 'Media',
]) . $model->media_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->media_id, 'url' => ['view', 'id' => $model->media_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="media-update">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
