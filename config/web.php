<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'MyFin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3j7iiEV94pwTDSM4E6zyuNq52Grgf7Cl',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
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
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'category/<action>/<id:\d+>' => 'category/<action>',                
                'sources/<action>/<id:\d+>' => 'sources/<action>',
                'operation/<action>/<id:\d+>' => 'operation/<action>',
            ],
        ],

        // компонент авторизации
        'auth' => \app\components\UsersAuthComponent::class,

        // компонент категорий - категории расходов/приходов
        'category' => \app\components\CategoryComponent::class,

        // компонент источников - карты/кошельки
        'sources' => app\components\SourcesComponent::class,

        // компонент операций - расходы/приходы
        'operation' => app\components\OperationComponent::class,

        // компонент типов операций - наличные/беналичные
        'operationType' => app\components\OperationTypeComponent::class,

        // авторизация - RBac
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'rbac' => [
            'class' => \app\components\RbacComponent::class,
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
