<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use conquer\select2\Select2Widget;
use yii\helpers\ArrayHelper;
use app\models\AuthItem;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'item_name')->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
                ]
            );
        ?>

        <?= $form->field($model, 'user_id')->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(User::find()->orderBy(['username'=>SORT_ASC, 'id'=>SORT_ASC])->all(), 'id', 'username')
                ]
            );
        ?>

        <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
