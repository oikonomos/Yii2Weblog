<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsLink */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Link',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Links'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->link_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
