<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsWebsightLog */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Websight Log',
]) . $model->idx;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Websight Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idx, 'url' => ['view', 'id' => $model->idx]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="websight-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
