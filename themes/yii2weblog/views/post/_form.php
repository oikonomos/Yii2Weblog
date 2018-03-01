<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\components\widgets\tinymce\TinyMCE;
use app\components\widgets\taxonomy\Taxonomy;
use app\models\TermTaxonomy;
use app\components\widgets\attachment\MediaAttachment;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php //$form->field($model, 'parent')->textInput(['maxlength' => true]) ?>

        <?php if (!$model->author_id): ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?php endif; ?>
        
        <?php if ($model->writer): ?>
        <?= Html::hiddenInput('writer', $model->writer) ?>
        <?php else: ?>
        <?= $form->field($model, 'writer')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>        
            
        <?php if ($model->email): ?>
        <?= Html::hiddenInput('email', $model->email) ?>
        <?php else: ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>

        <?php //$form->field($model, 'homepage')->textInput(['maxlength' => true]) ?>

        <div class="form-group field-post-term_taxonomy_id">
            <label class="control-label" for="category"><?= Yii::t('app', 'Term Taxonomy'); ?></label>
            <div id="category">
                <?php echo Html::hiddenInput('Post[term_taxonomy_id]', ($model->term_taxonomy_id) ? $model->term_taxonomy_id : 0, ['id'=>'post-term_taxonomy_id']); ?>
                <?php echo Html::hiddenInput('old_term_taxonomy_id', ($model->term_taxonomy_id) ? $model->term_taxonomy_id : 0, ['id'=>'old_term_taxonomy_id']); ?>
                <?php echo Html::dropDownList('category1', '', TermTaxonomy::findSiblings(0, $model->term_taxonomy_id, true), ['id'=>'category1', 'class'=>'form-control', 'style'=>'float:left;width:250px;margin:0 5px 16px 0;']); ?>
                <?php echo Html::dropDownList('category2', '',  array(), ['id'=>'category2', 'class'=>'form-control', 'style'=>'float:left;display:none;width:250px;margin:0 5px 16px 0;']); ?>
                <?php echo Html::dropDownList('category3', '',  array(), ['id'=>'category3', 'class'=>'form-control', 'style'=>'float:left;display:none;width:250px;margin:0 5px 16px 0;']); ?>
                <?php echo Html::dropDownList('category4', '',  array(), ['id'=>'category4', 'class'=>'form-control', 'style'=>'float:left;display:none;width:250px;margin:0 0 16px;']); ?>
            </div>
        </div>

        <div style="clear:both;"></div>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

        <div class="form-group field-post-attachment">
            <label class="control-label" for="attachments"><?= Yii::t('app', 'Media Attachment'); ?></label>

            <div id="attachment" class="attachment">
                <?= Html::button(Yii::t('app', 'Media Attachment'), ['id'=>'btn-attachment', 'class'=>'form-control', 'style'=>'width:250px;'])?>
                <ul id="attached-files" <?php echo ( !$model->isNewRecord ) ? 'style="display:block"' : '';?>>
                        <?php
                            if ( !$model->isNewRecord && $model->attachment ) {
                                $model->transformedAttachedFileFormat();
                            }
                        ?>
                        </ul>
            </div>

        </div>

        <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

        <?php if (!$model->isNewRecord): ?>

        <?= $form->field($model, 'status')->textInput() ?>

        <?= $form->field($model, 'post_type')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'comment_status')->textInput(['maxlength' => true]) ?>

        <?php endif; ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>

<?php echo TinyMCE::widget([
        'width' => '100%',
        'width' => '600',
        'id' => 'post-content',
]); ?>

<?= Taxonomy::widget([
    'IDSet' => implode('-', TermTaxonomy::findAllParents($model->term_taxonomy_id)),
    'url' => Url::to(['taxonomy/category']),
    'fieldID' => 'post-term_taxonomy_id',
    'csrfToken' => Yii::$app->request->csrfToken,
    'optionText'=>Yii::t('app', 'Taxonomy')
]); ?>

<?php echo MediaAttachment::widget([
        'url' => Url::to(["media/attach"]),
        'imgUrl' => 'http://www.enagape.org',
        'options' => array('id'=>'btn-attachment'),
        'name' => 'attachment',
]); ?>
