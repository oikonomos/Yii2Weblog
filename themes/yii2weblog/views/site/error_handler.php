<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

use yii\helpers\Html;

$this->title = $name;

?>
<div class="site-error">

    <h1><?= \Yii::t('app', $name) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(\Yii::t('app', $message)) ?>
    </div>

</div>
