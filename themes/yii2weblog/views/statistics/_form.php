<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsWebsightLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="websight-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'browser')->textInput() ?>

    <?= $form->field($model, 'domain')->textInput() ?>

    <?= $form->field($model, 'referer')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput() ?>

    <?= $form->field($model, 'searchengin')->textInput() ?>

    <?= $form->field($model, 'keyword')->textInput() ?>

    <?= $form->field($model, 'os')->textInput() ?>

    <?= $form->field($model, 'page')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
