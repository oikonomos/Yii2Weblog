<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modelsComment */

$this->title = $model->co_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-view">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <p class="viewbutton-wrap">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->co_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->co_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'co_id',
            'post_id',
            'author_id',
            'writer',
            'email:email',
            'url:url',
            'ip',
            'content:ntext',
            'parent',
            'status',
            'created_at',
            'updated_at',
            'group_id',
            'level',
            'sequence',
        ],
    ]) ?>

</div>
