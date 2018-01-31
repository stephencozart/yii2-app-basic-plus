<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'The Next Big Thing',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'container' => [
        'definitions' => [
            'app\interfaces\SearchServiceInterface' => [
                'class' => app\services\MySqlSearchService::class,
                'dataProvider' => [
                    'pagination' => [
                        'pageSize' => 50
                    ]
                ]
            ],
            'League\Flysystem\AdapterInterface' => [
                ['class' => \League\Flysystem\Adapter\Local::class],
                [dirname(__DIR__).'/storage']
            ],
            'League\Flysystem\FilesystemInterface' => [
                'class' => \League\Flysystem\Filesystem::class
            ]
        ]
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lo8CXdQkc_psMSxsCktLaiVFpUA82uiJ',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => '/user/login'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'admin/user'],
                //'admin/file-manager/collections' => 'admin/file-manager/collections',
                'admin/users/send-activation' => 'admin/user/send-activation',
                'admin/<controller:\w+>/<id:\d+>' => 'admin/<controller>/view',
                'admin/<controller:\w+>/<action:\w+>/<id:\d+>'=> 'admin/<controller>/<action>',
                'admin/<controller:\w+>/<action:\w+>'=> 'admin/<controller>/<action>',
                '<controller:\w+>/<id:\d+>'=> '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=> '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=> '<controller>/<action>'
            ],
        ],
        'recaptcha'=>[
            'class' => 'richweber\recaptcha\ReCaptcha',
            'siteKey' => '',
            'secretKey' => '',
            'errorMessage' => 'Are you robot?',
        ]
    ],
    'params' => $params,
    'modules'=>[
        'admin'=>[
            'class'=>'app\modules\admin\Module'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
