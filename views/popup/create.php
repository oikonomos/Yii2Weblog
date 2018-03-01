<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Popup */

$this->title = Yii::t('app', 'Create Popup');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Popups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="popup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
