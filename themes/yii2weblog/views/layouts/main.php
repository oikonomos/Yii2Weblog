<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\Yii2WeblogAppAsset;
use yii\widgets\Menu;
use yii\helpers\Url;
use app\components\widgets\popup\PopupWidget;

Yii2WeblogAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

        <?php if ( !Yii::$app->user->isGuest ): ?>        
        <div id="adminbar-navwrap" class="ab-navwrap">
                <ul id="ab-default" class="ab-nav-default">
<!--                        <li><a href="javascript:void(0);" class="btn-mobilemenu"><i class="fa fa-align-justify fa-lg"></i></a></li>-->
                        <li><a href="<?=(Yii::$app->user->isSuperAdmin)?Url::to(['site/dashboard']):Url::to(['site/dashboard2'])?>"><i class="fa fa-home fa-lg"></i><span class="sitename"> &nbsp; <?=Yii::$app->name?></span></a></li>
                </ul>
                <ul id="ab-secondary" class="ab-nav-secondary">
                        <li>
                                <a href="javascript:void(0);" id="ab-greeting" class="ab-greeting">
                                        <?=Yii::t('app', 'Hi') ?> <?=Yii::$app->user->displayName?> 
                                        <img src="<?=(Yii::$app->user->userphoto[1])?Yii::$app->user->userphoto[1]:'/images/user/nouserimage_17x17.png'?>" />
                                </a>
                                <div id="ab-profilewrap" class="ab-profilewrap">                                        
                                        <a href="<?=Url::to(['user/profile'])?>" title="<?=Yii::t('app', "Profile")?>"><img src="<?=(Yii::$app->user->userphoto[0])?Yii::$app->user->userphoto[0]:'/images/user/nouserimage.png'?>" class="user-photo" /></a>
                                        <div id="ab-profile-nav" class="ab-profile-nav">
                                                <?=Html::a(Yii::$app->user->displayName, ['/user/profile']) . PHP_EOL?>
                                                <?=Html::a(Yii::t('app', "Edit Profile"), ['/user/profile', 'id' => Yii::$app->user->id]) . PHP_EOL?>
                                                <?=( Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout'), ['class' => 'ab-logout']) . Html::endForm() ) . PHP_EOL?>
                                        </div>
                                </div>
                        </li>
                        <li>
                                <div id="ab-searchwrap" class="ab-searchwrap">
                                <?php
                                        echo Html::beginForm(['/site/admsearch'], 'post') . PHP_EOL;
                                        echo Html::hiddenInput('mode', 'admsearch') . PHP_EOL;
                                        echo Html::input('text', 'astx', '', [ 'id' => 'astx', 'placeholder' => Yii::t('app', 'Search Text') ]) . PHP_EOL;
                                        echo Html::button('<i class="fa fa-search"></i>', [ 'id' => 'btn-search', 'class' => 'btn-search' ]) . PHP_EOL;
                                        echo Html::endForm() . PHP_EOL;
                                ?>
                                </div>
                        </li>
                </ul>
        </div>        
        <?php endif; ?> 
         
        <?= $this->render('header.php') ?>
        
        <?= $this->render('content.php', ['content' => $content]) ?>
         
        <?= $this->render('footer.php') ?>
</div>

<?php if ( $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/site/index' ): ?>
<?= PopupWidget::widget([]); ?>
<?php endif; ?>
        
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
