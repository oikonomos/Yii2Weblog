<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsTerm */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Term',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Terms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->term_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="term-update">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
