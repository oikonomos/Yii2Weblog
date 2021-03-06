<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Term */

$this->title = Yii::t('app', 'Create Term');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Terms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-create">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
