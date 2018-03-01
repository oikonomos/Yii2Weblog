<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use conquer\select2\Select2Widget;
use app\models\Color;
use app\components\widgets\taxonomy\Taxonomy;
use app\models\Term;

/* @var $this yii\web\View */
/* @var $model app\modelsTermTaxonomy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="term-taxonomy-form">

    <?php $form = ActiveForm::begin(); ?>    

    <?= $form->field($termTaxonomy, 'term_id')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(Term::find()->orderBy( [ 'name'=>SORT_ASC] )->all(), 'term_id', 'name')
            ]
        );
    ?>

    <?= $form->field($termTaxonomy, 'taxonomy')->textInput() ?>

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

    <?= $form->field($termTaxonomy, 'color')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(Color::find()->orderBy( [ 'name'=>SORT_ASC] )->all(), 'name', 'name')
            ]
        );
    ?>

    <?= $form->field($termTaxonomy, 'color2')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(Color::find()->orderBy( [ 'name'=>SORT_ASC] )->all(), 'name', 'name')
            ]
        );
    ?>

    <?= $form->field($termTaxonomy, 'font')->widget(
            Select2Widget::className(),
            [
                'items' => ArrayHelper::map(Color::find()->orderBy( [ 'name'=>SORT_ASC] )->all(), 'name', 'name')
            ]
        );
    ?>
    
    <?php if ( !$termTaxonomy->isNewRecord ): ?>
    <?= $form->field($termTaxonomy, 'level')->textInput() ?>    
    <?= $form->field($termTaxonomy, 'sequence')->textInput() ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton($termTaxonomy->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $termTaxonomy->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= Taxonomy::widget([
    'IDSet' => implode('-', $termTaxonomy->findAllParents($termTaxonomy->term_taxonomy_id)),
    'url' => Url::to(['taxonomy/category']),
    'csrfToken' => Yii::$app->request->csrfToken,
    'optionText'=>Yii::t('app', 'Taxonomy')
]); ?>
