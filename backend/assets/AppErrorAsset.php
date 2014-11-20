<?php

namespace backend\assets;

use yii\web\AssetBundle;

class AppErrorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/static/backend';
    public $css = [
        'css/bootstrap-combined.min.css',
        'css/error404.css'
    ];
    public $js = ['js/admin.js'];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
