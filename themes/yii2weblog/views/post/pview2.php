<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\TermTaxonomy;

use nirvana\prettyphoto\PrettyPhoto;
use app\components\widgets\comment\Comment;
?>

<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['page_update', 'id' => $model->po_id], ['class' => 'btn btn-primary']) ?>
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
            'po_id',
            'author_id',
            'parent',
            'password',
            'writer',
            'title',
            'content:ntext',
            'excerpt:ntext',
            'email:email',
            'homepage',
            'created_at',
            'updated_at',
            'term_taxonomy_id',
            'status',
            'tags:ntext',
            'post_type',
            //'group_id',
            //'level',
            //'sequence',
            'hit_count',
            'comment_status',
            'comment_count',
        ],
    ]) ?>

</div>
