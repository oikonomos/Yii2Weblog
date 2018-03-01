<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsPopupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="popup-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'popup_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'width') ?>

    <?= $form->field($model, 'height') ?>

    <?= $form->field($model, 'dim_x') ?>

    <?php // echo $form->field($model, 'dim_y') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'popup_type') ?>

    <?php // echo $form->field($model, 'po_option') ?>

    <?php // echo $form->field($model, 'po_center') ?>

    <?php // echo $form->field($model, 'pages') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
