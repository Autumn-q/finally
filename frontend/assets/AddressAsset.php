<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/9
 * Time: 11:38
 */

namespace frontend\assets;


use yii\base\View;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AddressAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'style/base.css',
        'style/global.css',
        'style/header.css',
        'style/login.css',
        'style/footer.css',
        'style/home.css',
        'style/address.css',
        'style/bottomnav.css',
    ];
    public $js = [
        'js/header.js',
        'js/home.js',
        'js/jsAddress.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position'=>\yii\web\View::POS_HEAD,
    ];
}
