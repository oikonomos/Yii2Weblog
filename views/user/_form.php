<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use conquer\select2\Select2Widget;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modelsUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php if ( !$model->isNewRecord && (Yii::$app->user->id == 1) ): ?>
    <?= $form->field($model, 'role')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
            ]
        );
    ?>

    <?= $form->field($model, 'status')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map($model->getStates(), 'key', 'value')
            ]
        );
    ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
