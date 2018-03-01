<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="media-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //$form->field($model, 'owner_id')->textInput() ?>

    <?php //$form->field($model, 'file_mime_type')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'file_url')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'file_path')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'thumb_url')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'thumb_path')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'upfile')->fileInput() ?>

    <?= $form->field($model, 'caption')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 12]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
