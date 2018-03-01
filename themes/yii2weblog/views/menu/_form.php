<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Menu;
use conquer\select2\Select2Widget;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'menu_label')->textInput() ?>

        <?= $form->field($model, 'menu_link')->textInput() ?>

        <?= $form->field($model, 'menu_active')->textInput() ?>

        <?= $form->field($model, 'menu_layout')->textInput() ?>

        <?= $form->field($model, 'menu_params')->textInput() ?>

        <?= $form->field($model, 'menu_order')->textInput() ?>
        
        <?= $form->field($model, 'parent')->widget(
                Select2Widget::className(),
                [
                        'settings' => [
                                'placeholder' => Yii::t('app', 'Select a menu'),
                        ],
                        'items' => ArrayHelper::map(Menu::findMenus(), 'menu_id', 'menu_label')
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

        <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
