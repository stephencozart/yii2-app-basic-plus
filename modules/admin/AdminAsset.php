<?php
/**
 * Created by PhpStorm.
 * User: stephencozart
 * Date: 1/21/18
 * Time: 10:25 AM
 */

namespace app\modules\admin;


use yii\helpers\VarDumper;
use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dist/backend.css',
    ];

    public $js = [
        'dist/backend.js'
    ];

    public $depends = [

    ];
}