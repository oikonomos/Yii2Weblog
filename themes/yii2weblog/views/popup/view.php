<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modelsPopup */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Popups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="popup-view">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <p class="viewbutton-wrap">
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->popup_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->popup_id], [
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
            //'popup_id',
            'title',
            'width',
            'height',
            'dim_x',
            'dim_y',
            'start_date',
            'end_date',
            'popup_type',
            'po_option',
            'po_center',
            'pages:ntext',
            'created_at',
            'updated_at',
            [
                    'label' => Yii::t('app', 'Content'),
                    'value' => $model->content,
                    'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
