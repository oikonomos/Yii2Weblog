<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modelsPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <p class="viewbutton-wrap">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->po_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->po_id], [
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
            //'po_id',
            //'author_id',
            //'parent',
            //'password',
            'writer',
            'email:email',
            'homepage',
            'created_at',
            'updated_at',
            'status',
            //'group_id',
            //'level',
            //'sequence',
            'hit_count',
            'comment_status',
            'comment_count',
            'title',
            'termname',
            'post_type',
            [
                    'attribute' => 'excerpt',
                    'format' => 'raw',
            ],
            [
                    'attribute' => 'content',
                    'format' => 'raw',
            ],
            [
                    'attribute' => 'tags',
                    'format' => 'raw',
            ],
            [
                    'attribute' => 'attachments',
                    'format' => 'raw',
            ]
        ],
    ]) ?>

</div>
