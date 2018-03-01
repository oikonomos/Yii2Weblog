<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modelsOption */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Config Site');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-config">

    <h1><?= Html::encode($this->title) ?></h1>

        <div class="option-form">

            <?php $form = ActiveForm::begin(); ?>

                <?php foreach ( $options as $option ): ?>                
                        <?= $form->field($option, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($option, 'value')->textarea(['rows' => 6]) ?> 
                <?php endforeach; ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

</div>
