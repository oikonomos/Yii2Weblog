<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TermTaxonomy */

$this->title = Yii::t('app', 'Create Term Taxonomy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Term Taxonomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-taxonomy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'termTaxonomy' => $termTaxonomy,
        'term' => $term,
    ]) ?>

</div>
