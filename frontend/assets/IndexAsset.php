<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/11
 * Time: 10:11
 */

namespace frontend\assets;


use yii\web\AssetBundle;
use yii\web\View;

class IndexAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/bottomnav.css',
        'style/footer.css',

    ];
    public $js = [
        'js/jquery-1.8.3.min.js',
        'js/header.js',
        'js/goods.js',
        'js/jqzoom-core.js'
        //'js/jqzoom.pack.1.0.1.js'
    ];
    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position'=>\yii\web\View::POS_HEAD,
    ];
}