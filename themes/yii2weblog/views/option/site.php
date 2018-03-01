<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Config Site');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-create">

        <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

        <div class="option-form">

                <?php $form = ActiveForm::begin(); ?>

                <?php 
                foreach ( $dataProvider->getModels() AS $model ) { 
                        $name = explode('-', $model->name);
                ?>
                <div class="form-group field-<?=$model->name?> has-success">
                        <label class="control-label" for="<?=$model->name?>"><?= Yii::t('app', ucfirst($name[0]).' '.ucfirst($name[1])); ?></label>
                        <?php if ( !in_array($model->name, ['site-privacy', 'site-useofterms']) ): ?>
                        <?= Html::input('text', 'Site['.$model->name.']', $model->value, [ 'id' => $model->name, 'class' => 'form-control' ]) ?>
                        <?php else: ?>
                        <?= Html::textarea('Site['.$model->name.']', $model->value, [ 'id' => $model->name, 'class' => 'form-control' ]) ?>
                        <?php endif; ?>
                        <div class="help-block"></div>
                </div>
                <?php } ?>

                <?php if ( $dataProvider->totalCount ): ?>
                <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?php endif; ?>

                <?php ActiveForm::end(); ?>

        </div>

</div>
