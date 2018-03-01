<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\widgets\Menu;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                        <li><a href="<?=Url::to(['site/dashboard'])?>"><i class="fa fa-home"></i> <?=Yii::$app->name?></a></li>
                </ul>
                <ul id="ab-secondary" class="ab-nav-secondary">
                        <li><span>안녕하세요 <?=Yii::$app->user->displayName?>님</span></li>
                        <li><?=( Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout'), ['class' => 'btn btn-link logout']) . Html::endForm())?></li>
                </ul>
        </div>        
        <?php endif; ?> 
         
        <div id="header" class="container">
                <div class="logowrap">
                        <div class="logo"><?=Yii::$app->name?></div>
                </div>
                
                <div id="primary-navwrap" class="pr-navwrap">
                <?php
                $items = [
                        'activateParents' => true,
                        'encodeLabels' => false,
                        'options' => ['id'=>'primary-nav', 'class' => 'pr-nav'],
                         'items' => [
                                ['label' => Yii::t('app', 'Notice'), 'url' => ['/post/list', 'tt_id'=>2]],
                                ['label' => Yii::t('app', 'FAQ'), 'url' => ['/post/list', 'tt_id'=>4]],
                                ['label' => Yii::t('app', 'QNA'), 'url' => ['/post/list', 'tt_id'=>1]],
                                ['label' => Yii::t('app', 'Manual'), 'url' => ['/post/list', 'tt_id'=>3]],
                                Yii::$app->user->isGuest ? (
                                    ['label' => 'Login', 'url' => ['/site/login']]
                                ) : ('')
                        ]
                ];
                echo Menu::widget($items);
                ?>    
                </div>
        </div>
        
        <div id="contents" class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
        </div>
</div>

<footer id="footer" class="footer">
    <div id="copyright" class="container">
        <p class="pull-left">&copy; ARAM Communications 2017</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
