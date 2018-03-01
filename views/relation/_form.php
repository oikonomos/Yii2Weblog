<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use conquer\select2\Select2Widget;
use yii\helpers\ArrayHelper;
use app\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model app\modelsAuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(AuthItem::find()->orderBy(['type'=>SORT_ASC, 'name'=>SORT_ASC])->all(), 'name', 'name')
            ]
        );
    ?>

    <?= $form->field($model, 'child')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(AuthItem::find()->orderBy(['type'=>SORT_ASC, 'name'=>SORT_ASC])->all(), 'name', 'name')
            ]
        );
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
