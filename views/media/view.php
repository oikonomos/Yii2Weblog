<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modelsMedia */

$this->title = Yii::t('app', 'View: ') . $model->media_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->media_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->media_id], [
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
            'media_id',
            'owner_id',
            'display_filename',
            'filename',
            'caption',
            'file_size',
            'file_type',
            'file_mime_type',
            'file_url:url',
            'file_path',
            'thumb_url:url',
            'thumb_path',
            'thumb_width',
            'thumb_height',
            'created_at',
            'updated_at',
            'description:ntext',
        ],
    ]) ?>

</div>
