<?php

return [
    'id' => 'grid-view-demo',
    'aliases' => [],
    'language' => 'zh-CN',
    'basePath' => Yii::getAlias('@app'),
    'runtimePath' => '@runtime',
    'controllerNamespace' => 'app\controllers\http',
    'defaultRoute' => 'index',
    'timeZone' => env()->get('TZ'),
    'bootstrap' => ['log'],
    'components' => [
        'cache' => require __DIR__ . '/components/cache.php',
        'db' => require __DIR__ . '/components/db.php',
        'log' => require __DIR__ . '/components/log-http.php',
        'request' => require __DIR__ . '/components/http-request.php',
        'assetManager' => require __DIR__ . '/components/asset-manager.php',
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/',
        ],
    ],
    'params' => [],
];
