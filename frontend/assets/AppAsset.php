<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/static/frontend/assets';
    public $baseUrl = '@web/static/frontend';
    public $css = [
	    //'css\bootstrap.css',
        'css/site.css'
    ];
    public $js = [
        'js/site.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
