<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use conquer\select2\Select2Widget;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modelsAuthRule */
/* @var $form yii\widgets\ActiveForm */
$classnames = [
        [
                'key' => 'app\\rbac\\AuthorRue',
                'value' => 'app\\rbac\\AuthorRue'
        ]
];
?>

<div class="auth-rule-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php if (!$model->isNewRecord): ?>
        <?= Html::hiddenInput('old_name', $model->name) ?>
        <?php endif; ?>
        
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'classname')->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map($classnames, 'key', 'value')
                ]
            );
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
