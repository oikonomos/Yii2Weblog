<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use janisto\timepicker\TimePicker;
use app\components\widgets\tinymce\TinyMCE;

/* @var $this yii\web\View */
/* @var $model app\modelsPopup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="popup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'start_date', ['template'=>'{input} {error}'])->widget(TimePicker::className(), [
            'language' => 'ko',
            'mode' => 'datetime',
            'clientOptions'=>[
                'dateFormat' => 'yy-mm-dd',
                'timeFormat' => 'HH:mm:ss',
                'showSecond' => true,
            ]
        ]);
    ?>
    
    <?= $form->field($model, 'end_date', ['template'=>'{input} {error}'])->widget(TimePicker::className(), [
            'language' => 'ko',
            'mode' => 'datetime',
            'clientOptions'=>[
                'dateFormat' => 'yy-mm-dd',
                'timeFormat' => 'HH:mm:ss',
                'showSecond' => true,
            ]
        ]);
    ?>

    <?= $form->field($model, 'popup_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'po_option')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'po_center')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dim_x')->textInput() ?>

    <?= $form->field($model, 'dim_y')->textInput() ?>

    <?= $form->field($model, 'pages')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 12]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php echo TinyMCE::widget([
        'width' => '100%',
        'width' => '600',
        'id' => 'popup-content',
]); ?>
