<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class RunAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        'frontend\assets\RouteAsset',
        'frontend\assets\NoteAsset',
        'frontend\assets\TagAsset',
    ];
    public $jsOptions = [
        'defer' => true
    ];
}
