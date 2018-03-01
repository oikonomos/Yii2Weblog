<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use yii\widgets\Menu;
use yii\helpers\Url;

AdminAsset::register($this);
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
                        <li><a href="javascript:void(0);" class="btn-mobilemenu"><i class="fa fa-align-justify fa-lg"></i></a></li>
                        <li><a href="<?=Url::to(['site/index'])?>"><i class="fa fa-home fa-lg"></i><span class="sitename"> &nbsp; <?=Yii::$app->name?></span></a></li>
                </ul>
                <ul id="ab-secondary" class="ab-nav-secondary">
                        <li>
                                <a href="javascript:void(0);" id="ab-greeting" class="ab-greeting">
                                        안녕하세요 <?=Yii::$app->user->displayName?>님 
                                        <img src="/images/user/nouserimage_17x17.png" />
                                </a>
                                <div id="ab-profilewrap" class="ab-profilewrap">                                        
                                        <a href="<?=Url::to(['user/profile'])?>" title="<?=Yii::t('app', "Profile")?>"><img src="/images/user/nouserimage.png" /></a>
                                        <div id="ab-profile-nav" class="ab-profile-nav">
                                                <?=Html::a(Yii::$app->user->displayName, ['/user/profile']) . PHP_EOL?>
                                                <?=Html::a(Yii::t('app', "Edit Profile"), ['/user/profile']) . PHP_EOL?>
                                                <?=( Html::beginForm(['/site/logout'], 'post') . Html::submitButton(Yii::t('app', 'Logout'), ['class' => 'ab-logout']) . Html::endForm() ) . PHP_EOL?>
                                        </div>
                                </div>
                        </li>
                        <li>
                                <div id="ab-searchwrap" class="ab-searchwrap">
                                <?php
                                        echo Html::beginForm(['/site/logout'], 'post') . PHP_EOL;
                                        echo Html::hiddenInput('mode', 'omnisearch') . PHP_EOL;
                                        echo Html::input('text', 'gstx', '', [ 'id' => 'gstx', 'placeholder' => Yii::t('app', 'Search Text') ]) . PHP_EOL;
                                        echo Html::button('<i class="fa fa-search"></i>', [ 'id' => 'btn-search', 'class' => 'btn-search' ]) . PHP_EOL;
                                        echo Html::endForm() . PHP_EOL;
                                ?>
                                </div>
                        </li>
                </ul>
        </div>        
        <?php endif; ?> 

        <div id="sidebar-navwrap" class="sb-navwrap">
        <?php
        if (Yii::$app->user->role == 'author') {
                $items = [
                        [
                                'label' => '<i class="fa fa-dashboard"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Dashboard') . '</span>',
                                'url' => ['site/dashboard'],
                                'active' => $this->context->route == 'site/dashboard'
                        ],
                        [
                                'label' => '<i class="fa fa-archive"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Posts') . '</span>',
                                'url' => ['post/'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Posts'),
                                                'url' => ['post/'],
                                                'active' => in_array($this->context->route, array('post/index', 'post/view', 'post/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Create Post'),
                                                'url' => ['post/create'],
                                                'active' => in_array($this->context->route, array('post/create')) ? true : false
                                        ]
                                ]
                        ],
                        /*[
                                'label' => '<i class="fa fa-comments"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Comments') . '</span>',
                                'url' => ['comment/'],
                                'active' => in_array($this->context->route, array('comment/index', 'comment/view', 'comment/create', 'comment/update')) ? true : false
                        ],*/
                        [
                                'label' => '<i class="fa fa-file-archive-o"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Media') . '</span>',
                                'url' =>  ['media/'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Media'),
                                                'url' => ['media/'],
                                                'active' => in_array($this->context->route, array('media/index', 'media/view', 'media/create', 'media/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Multiple File Upload'),
                                                'url' => ['media/upload'],
                                                'active' => $this->context->route == 'media/upload'
                                        ],
                                ]
                        ],
                        [
                                'label' => '<i class="fa fa-link"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Links') . '</span>',
                                'url' => ['link/'],
                                'active' => in_array($this->context->route, array('link/index', 'link/view', 'link/create', 'link/update')) ? true : false
                        ],
                        /*[
                                'label' => '<i class="fa fa-square"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Popups') . '</span>',
                                'url' => ['popup/'],
                                'active' => in_array($this->context->route, array('popup/index', 'popup/view', 'popup/create', 'popup/update')) ? true : false
                        ],*/
                        [
                                'label' =>  '<i class="fa fa-arrow-circle-left"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Collapse Menu') . '</span>',
                                'url' => 'javascript:void();',
                                'options' => ['class'=>'collapse-menu']
                        ],
                ];
        }
        else {
                $items = [
                        [
                                'label' => '<i class="fa fa-dashboard"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Dashboard') . '</span>',
                                'url' => ['site/dashboard'],
                                'active' => $this->context->route == 'site/dashboard'
                        ],
                        [
                                'label' => '<i class="fa fa-shield"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Security') . '</span>',
                                'url' => ['/assignment'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Auth Assignments'),
                                                'url' => ['assignment/'],
                                                'active' => in_array($this->context->route, array('assignment/index', 'assignment/view', 'assignment/create', 'assignment/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Auth Items'),
                                                'url' => ['permission/'],
                                                'active' => in_array($this->context->route, array('permission/index', 'permission/view', 'permission/create', 'permission/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Auth Item Children'),
                                                'url' => ['relation/'],
                                                'active' => in_array($this->context->route, array('relation/index', 'relation/view', 'relation/create', 'relation/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Auth Rules'),
                                                'url' => ['rule/'],
                                                'active' => in_array($this->context->route, array('rule/index', 'rule/view', 'rule/create', 'rule/update')) ? true : false
                                        ]
                                ]
                        ],
                        [
                                'label' => '<i class="fa fa-users"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Users') . '</span>',
                                'url' => ['user/'],
                                'active' => in_array($this->context->route, array('user/index', 'user/view', 'user/create', 'user/update')) ? true : false
                        ],
                        [
                                'label' => '<i class="fa fa-archive"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Posts') . '</span>',
                                'url' => ['post/'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Posts'),
                                                'url' => ['post/'],
                                                'active' => in_array($this->context->route, array('post/index', 'post/view', 'post/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Terms'),
                                                'url' => ['term/'],
                                                'active' => in_array($this->context->route, array('term/index', 'term/view', 'term/create', 'term/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Term Taxonomies'),
                                                'url' => ['taxonomy/cindex'],
                                                'active' => in_array($this->context->route, array('taxonomy/cindex', 'taxonomy/cview', 'taxonomy/create', 'taxonomy/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Create Post'),
                                                'url' => ['post/create'],
                                                'active' => in_array($this->context->route, array('post/create')) ? true : false
                                        ]
                                ]
                        ],
                        [
                                'label' => '<i class="fa fa-comments"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Comments') . '</span>',
                                'url' => ['comment/'],
                                'active' => in_array($this->context->route, array('comment/index', 'comment/view', 'comment/create', 'comment/update')) ? true : false
                        ],
                        [
                                'label' => '<i class="fa fa-file-archive-o"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Media') . '</span>',
                                'url' =>  ['media/'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Media'),
                                                'url' => ['media/'],
                                                'active' => in_array($this->context->route, array('media/index', 'media/view', 'media/create', 'media/update')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Multiple File Upload'),
                                                'url' => ['media/upload'],
                                                'active' => $this->context->route == 'media/upload'
                                        ],
                                ]
                        ],
                        [
                                'label' => '<i class="fa fa-link"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Links') . '</span>',
                                'url' => ['link/'],
                                'active' => in_array($this->context->route, array('link/index', 'link/view', 'link/create', 'link/update')) ? true : false
                        ],
                        [
                                'label' => '<i class="fa fa-square"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Popups') . '</span>',
                                'url' => ['popup/'],
                                'active' => in_array($this->context->route, array('popup/index', 'popup/view', 'popup/create', 'popup/update')) ? true : false
                        ],
                        [
                                'label' => '<i class="fa fa-square"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Appearance') . '</span>',
                                'url' => ['theme/'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Theme'),
                                                'url' => ['theme/'],
                                                'active' => in_array($this->context->route, array('theme/index')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Menu'),
                                                'url' => ['theme/menu'],
                                                'active' => in_array($this->context->route, array('theme/menu')) ? true : false
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Options'),
                                                'url' => ['option/index'],
                                                'active' => in_array($this->context->route, array('option/index', 'option/view', 'option/create', 'option/update')) ? true : false,
                                        ],
                                ]
                        ],
                        [
                                'label' => '<i class="fa fa-calculator"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Statistics') . '</span>',
                                'url' => ['statistics/'],
                                'items' => [
                                        [
                                                'label' => Yii::t('app', 'Websight Logs'),
                                                'url' => ['statistics/'],
                                                'active' =>$this->context->route == 'statistics/index'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Counters'),
                                                'url' => ['statistics/counter'],
                                                'active' => $this->context->route == 'statistics/counter'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Browsers'),
                                                'url' => ['statistics/browser'],
                                                'active' => $this->context->route == 'statistics/browser'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Domains'),
                                                'url' => ['statistics/domain'],
                                                'active' => $this->context->route == 'statistics/domain'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Ips'),
                                                'url' => ['statistics/ip'],
                                                'active' => $this->context->route == 'statistics/ip'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Keywords'),
                                                'url' => ['statistics/keyword'],
                                                'active' => $this->context->route == 'statistics/keyword'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Os'),
                                                'url' => ['statistics/os'],
                                                'active' => $this->context->route == 'statistics/os'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Pages'),
                                                'url' => ['statistics/page'],
                                                'active' => $this->context->route == 'statistics/page'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Referers'),
                                                'url' => ['statistics/referer'],
                                                'active' => $this->context->route == 'statistics/referer'
                                        ],
                                        [
                                                'label' => Yii::t('app', 'Websight Log Searchengins'),
                                                'url' => ['statistics/searchengin'],
                                                'active' => $this->context->route == 'statistics/searchengin'
                                        ]
                                ]
                        ],
                        [
                            'label' => '<i class="fa fa-file-code-o"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Gii') . '</span>',
                            'url' => ['/gii'],
                        ],
                        [
                                'label' =>  '<i class="fa fa-arrow-left"></i> <span class="sb-menu-label"> &nbsp;' . Yii::t('app', 'Collapse Menu') . '</span>',
                                'url' => 'javascript:void(0);',
                                'options' => ['class'=>'collapse-menu']
                        ],
                ];
        }
        $menus = [
                'activateParents' => true,
                'encodeLabels' => false,
                'options' => ['id'=>'sidebar-nav', 'class' => 'sb-nav'],
                'items' => $items
        ];
        echo Menu::widget($menus);
        ?>
        </div>

        <div id="contents" class="contents">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
        </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ARAM Communications 2017</p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php
$this->registerJsFile('/js/admin/gnb.js', [
        'depends' => [
                'yii\web\YiiAsset',
                'yii\bootstrap\BootstrapAsset',
        ]
]);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
