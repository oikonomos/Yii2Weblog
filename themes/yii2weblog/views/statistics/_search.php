<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsWebsightLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="websight-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idx') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'browser') ?>

    <?= $form->field($model, 'domain') ?>

    <?= $form->field($model, 'referer') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'searchengin') ?>

    <?php // echo $form->field($model, 'keyword') ?>

    <?php // echo $form->field($model, 'os') ?>

    <?php // echo $form->field($model, 'page') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
