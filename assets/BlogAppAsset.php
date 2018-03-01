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
class BlogAppAsset extends AssetBundle
{
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [
                'themes/blog/css/normalize.css',
                'themes/blog/css/site.css',
        ];
        public $js = [
                'themes/blog/js/site.js',
                'themes/blog/js/gnb.js',
                'themes/blog/js/my-slider-1.3.8.js',
                'themes/blog/js/ready.js'
        ];
        public $depends = [
                'yii\web\YiiAsset',
                'yii\bootstrap\BootstrapAsset',
                'rmrevin\yii\fontawesome\AssetBundle',
                //'app\assets\AngularAsset',
        ];
}
