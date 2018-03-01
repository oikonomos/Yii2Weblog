<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = Yii::t('app', 'Create Page');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['post/page']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_pform', [
        'model' => $model,
    ]) ?>

</div>
