<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsPopup */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Popup',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Popups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->popup_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="popup-update">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
