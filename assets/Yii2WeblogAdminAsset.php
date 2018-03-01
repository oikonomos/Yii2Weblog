<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Yii2WeblogAdminAsset extends AssetBundle
{
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [
                'themes/yii2weblog/css/normalize.css',
                'themes/yii2weblog/css/admin.css',
        ];
        public $js = [
                'themes/yii2weblog/js/admin/admin.js'
        ];
        public $depends = [
                'yii\web\YiiAsset',
                'yii\bootstrap\BootstrapAsset',
                'rmrevin\yii\fontawesome\AssetBundle',
        ];
}
