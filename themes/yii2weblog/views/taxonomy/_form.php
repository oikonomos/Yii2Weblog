<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use conquer\select2\Select2Widget;
use app\models\Color;
use app\components\widgets\taxonomy\Taxonomy;
use app\models\Term;
use app\models\TermTaxonomy;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $termTaxonomy app\modelsTermTaxonomy */
/* @var $term app\modelsTerm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="term-taxonomy-form">

        <?php $form = ActiveForm::begin(); ?>
        
        <?php if ( !$term->isNewRecord ): ?>
        <?= $form->field($term, 'term_id', [ 'template' => '{input}{error}' ])->hiddenInput() ?>
        <?php endif; ?>

        <?= $form->field($term, 'name', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}</div></div>' ])->textInput() ?>
        
        <?= $form->field($term, 'slug', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->textInput()->hint("“슬러그(slug)” 는 이름의 URL-친화적인 버전이며 모두 소문자로 이루어져 있으며 글자, 숫자와 하이픈으로 이뤄져 있습니다.") ?>

        <?= $form->field($termTaxonomy, 'taxonomy', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}</div></div>' ])->textInput() ?>

        <div class="form-group field-termtaxonomy-taxonomy">
                <label class="control-label" for="category"><?= Yii::t('app', 'Parent'); ?></label>
                <div id="category">
                <?php echo Html::hiddenInput('TermTaxonomy[parent]', ($termTaxonomy->parent) ? $termTaxonomy->parent : 0, ['id'=>'parent']); ?>
                <?php echo Html::hiddenInput('prev_parent', ($termTaxonomy->parent) ? $termTaxonomy->parent : 0, ['id'=>'prev_parent']); ?>
                <?php echo Html::dropDownList('category1', '',  $termTaxonomy->findSiblings(0, $termTaxonomy->taxonomy, true), ['id'=>'category1', 'class'=>'form-control', 'style'=>'float:left;width:250px;margin:0 5px 16px 0;']); ?>
                <?php echo Html::dropDownList('category2', '',  array(), ['id'=>'category2', 'class'=>'form-control', 'style'=>'float:left;display:none;width:250px;margin:0 5px 16px 0;']); ?>
                <?php echo Html::dropDownList('category3', '',  array(), ['id'=>'category3', 'class'=>'form-control', 'style'=>'float:left;display:none;width:250px;margin:0 5px 16px 0;']); ?>
                <?php echo Html::dropDownList('category4', '',  array(), ['id'=>'category4', 'class'=>'form-control', 'style'=>'float:left;display:none;width:250px;margin:0 0 16px;']); ?>
                </div>
        </div>

        <div style="clear:both;"></div>

        <div id="colorbox" style="padding: 20px 0;">
                <ul style="display: table;list-style: none; width: 602px; border:1px solid #000; margin: 0; padding: 0;">
                <?php
                    $colorModels = Color::find()->orderBy( [ 'name'=>SORT_ASC] )->all();
                    foreach ( $colorModels as $colorModel ) {
                        echo '<li style="float: left; width: 30px; line-height: 30px;" title="' . $colorModel->name . '">' . $colorModel->getColorSample() . '</li>';
                    }
                ?>
                </ul>
        </div>

        <?= $form->field($termTaxonomy, 'color', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                ColorInput::className(),
                [
                        'options' => ['placeholder' => Yii::t('app', 'Select')]
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'color2', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                ColorInput::className(),
                [
                        'options' => ['placeholder' => Yii::t('app', 'Select')]
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'font', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                ColorInput::className(),
                [
                        'options' => ['placeholder' => Yii::t('app', 'Select')]
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'write_level', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'update_level', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'view_level', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'list_level', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
                ]
            );
        ?>

        <?= $form->field($termTaxonomy, 'reply_level', [ 'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>' ])->widget(
                Select2Widget::className(),
                [
                    'items' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name')
                ]
            );
        ?>

        <div class="form-group">
                <?= Html::submitButton($termTaxonomy->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $termTaxonomy->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>

<?= Taxonomy::widget([
    'IDSet' => implode('-', $termTaxonomy->findAllParents($termTaxonomy->parent)),
    'url' => Url::to(['taxonomy/category']),
    'csrfToken' => Yii::$app->request->csrfToken,
    'optionText'=>Yii::t('app', 'Taxonomy')
]); ?>
