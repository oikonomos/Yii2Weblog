<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsAuthItem */
/* @var $form yii\widgets\ActiveForm */

$types = [
    ['key'=>'1', 'value'=>Yii::t('app', 'Role')],
    ['key'=>'2', 'value'=>Yii::t('app', 'Permission')]
];
?>

<div class="auth-item-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php if ( !$model->isNewRecord ): ?>
        <?= Html::hiddenInput('old_name', $model->name) ?>
        <?php endif; ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'type')->dropDownList( ArrayHelper::map($types, 'key', 'value')) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
