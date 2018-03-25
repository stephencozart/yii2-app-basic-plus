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
            'class' => \yii\rbac\DbManager::class,
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lo8CXdQkc_psMSxsCktLaiVFpUA82uiJ',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => true,
            'loginUrl' => '/user/login'
        ],
        'view' => [
            'class' => \app\local\View::class
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ',',
            'currencyCode' => 'USD',
            'timeZone' => 'America/Chicago',
        ],
        'mailer' => [
            'class' => \yii\swiftmailer\Mailer::class,
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
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
                [
                    'class' => \app\rules\EntryTypeUrlRule::class
                ],
                [
                    'class' => \app\rules\EntryRule::class
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => [
                        'admin/user',
                        'admin/media-library' => 'admin/media-library',
                        'admin/entry-type',
                        'admin/entry-type-field',
                        'admin/entry',
                    ]
                ],
                //'admin/file-manager/collections' => 'admin/file-manager/collections',
                'admin/entries/publish/<id:\d+>' => 'admin/entry/publish',
                'admin/entries/un-publish/<id:\d+>' => 'admin/entry/un-publish',
                'admin/entry-types/sort-fields/<id:\d+>' => 'admin/entry-type/sort-fields',
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
            'class' => \richweber\recaptcha\ReCaptcha::class,
            'siteKey' => '',
            'secretKey' => '',
            'errorMessage' => 'Are you robot?',
        ]
    ],
    'params' => $params,
    'modules'=>[
        'admin'=>[
            'class'=>\app\modules\admin\Module::class,
            'googleMapsApiKey' => 'AIzaSyDn6Qdx4HpxcrdPOkgGt8fULbhoadoN6nY'
        ]
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
    ];
}

return $config;
