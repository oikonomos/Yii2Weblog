<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsOption */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Option',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->option_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="option-update">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
