<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modelsUser */

$this->title = Yii::t('app', 'Edit Profile : ', [
    'modelClass' => 'User',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Profile');
?>
<div class="user-profile">

    <h1 class="view-title"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_profile', [
        'model' => $model,
        'usermeta' => $usermeta,
        'media' => $media,
    ]) ?>

</div>
