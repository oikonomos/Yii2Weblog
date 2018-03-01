<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsTermTaxonomy */

$this->title = Yii::t('app', 'Term Taxonomy') . ': ' . $termTaxonomy->term_taxonomy_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Term Taxonomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $termTaxonomy->term_taxonomy_id, 'url' => ['view', 'id' => $termTaxonomy->term_taxonomy_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="term-taxonomy-update">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'termTaxonomy' => $termTaxonomy,
        'term' => $term,
    ]) ?>

</div>
