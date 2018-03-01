<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modelsWebsightLog */

$this->title = Yii::t('app', 'Create Websight Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Websight Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="websight-log-create">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
